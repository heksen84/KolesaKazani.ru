<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use App\Images;

// https://laracasts.com/discuss/channels/laravel/saving-an-intervention-image-instance-into-amazon-s3?page=1

              /*$image->text("ilbo.site", 10,28, function($font) {
                    $font->file(public_path()."/fonts/Brushie.ttf");
                    $font->color(array(255,255,255,1));
                    $font->size(24);
                });*/


class LoadImages implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $images;        

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($images) {
        $this->images = $images;        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {

        foreach($this->images as $img) {         
            
            $img_loaded = false;
            
            // потом беру из локальной папки и преобразую
            $image = Image::make($img["path"].$img["name"]);            
            
            if ($img["type"] === "normal") {
                $image->fit(800, 600);
                $img_loaded = Storage::disk('s3')->put("images/normal/".$img["name"], $image->stream()->detach())?true:false;
                Images::where("name", $img["name"])->update(array("storage_id" => 2));
            }

            if ($img["type"] === "small") {
                $image->fit(250, 250);                
                $img_loaded = Storage::disk('s3')->put("images/small/".$img["name"], $image->stream()->detach())?true:false;
                Images::where("name", $img["name"])->update(array("storage_id" => 5));
            }

            //if ($img_loaded) {                
                // записываю true в storage_id при условии
                //Images::where("name", $img["name"])->update(array("storage_id" => 1));
            //}

        }        
    }
}
