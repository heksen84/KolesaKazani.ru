<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Images;

class LoadImages implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Request $request, $advert_id) {

        $MAX_IMAGE_WIDTH  = 1024;
        $MAX_IMAGE_HEIGHT = 768;

        if ($request->images)

        // бегу по картинкам
        foreach($request->file("images") as $img) {

            // формирую рандомное имя
            $filename = str_random(32).".".$img->getClientOriginalExtension();
            
            // узнаю имя
            $image = Image::make($img->getRealPath());       

            \Debugbar::info($image->width()."x".$image->height());
            
            if ( $image->width()>$MAX_IMAGE_WIDTH && $image->height()>$MAX_IMAGE_HEIGHT) {                
                // изменяю размер с соотношением пропорций
                $image->resize($MAX_IMAGE_WIDTH, $MAX_IMAGE_HEIGHT, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            
            $image->save(storage_path().'/app/images/normal/' .$filename);
                        
            // изменяю размер с соотношением пропорций
            $image->resize(200, 150, function ($constraint) {
                $constraint->aspectRatio();
            });
            
            $image->save(storage_path().'/app/images/small/' .$filename);                        

            // добавляю запись в базу       
            $imageRec = new Images();            
            $imageRec->advert_id = $advert_id;
            $imageRec->name = $filename;                            
            $imageRec->save();                                    

        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {}
}
