<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic as Image;

// https://laracasts.com/discuss/channels/laravel/saving-an-intervention-image-instance-into-amazon-s3?page=1

              /*$image->text("ilbo.kz", 10,28, function($font) {
                    $font->file(public_path()."/fonts/Brushie.ttf");
                    $font->color(array(255,255,255,1));
                    $font->size(24);
                });*/


class LoadImages implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $images;    
    private $advert_id;    

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($images, $advert_id) {
        $this->images = $images;
        $this->advert_id = $advert_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {

        foreach($this->images as $img) {                

            //$image->save($img["path"].$img["name"]);
            //$image = Image::make($img["path"].$img["name"]);
            
            // внечале сохраняю
            //$image = Image::make($img["real_path"]);            
            //$image->save($img["path"].$img["name"]);

            // потом беру из локальной папки и преобразую
            $image = Image::make($img["path"].$img["name"]);            
            
            if ($img["type"]=="normal") {
                $image->fit(1024, 768);
               \Storage::disk('s3')->put("images/normal/".$img["name"], $image->stream()->detach());
            }

            if ($img["type"]=="small") {
                $image->fit(250, 250);                
                \Storage::disk('s3')->put("images/small/".$img["name"], $image->stream()->detach());
            }                        
                            
        }
        
    }
}
