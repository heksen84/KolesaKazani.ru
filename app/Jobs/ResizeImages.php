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


class ResizeImages implements ShouldQueue {
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
            
            // беру из локальной папки
            $image = Image::make($img["path"].$img["name"]);            
            
            // и преобразую
            if ($img["type"] === "normal")
                $image->fit(800,600)->save($img["path"].$img["name"]);

            if ($img["type"] === "small")
                $image->fit(250,250)->save($img["path"].$img["name"]);                                                          

        }                
                
    }
}
