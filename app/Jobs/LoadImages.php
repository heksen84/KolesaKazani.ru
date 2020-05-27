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

// https://laracasts.com/discuss/channels/laravel/saving-an-intervention-image-instance-into-amazon-s3?page=1

class LoadImages implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Request $request, $advert_id) {
        if ($request->images) {

            // бегу по картинкам
            foreach($request->file("images") as $img) {
                
                $image = Image::make($img->getRealPath());
                
                $image->fit(1024, 768);                
                
                /*$image->text("ilbo.kz", 10,28, function($font) {
                    $font->file(public_path()."/fonts/Brushie.ttf");
                    $font->color(array(255,255,255,1));
                    $font->size(24);
                });*/

                $name = time()."_".$img->getClientOriginalName();                                
                \Storage::disk('s3')->put("images/normal/".$name, $image->stream()->detach());

                $image->fit(250, 250);                
                \Storage::disk('s3')->put("images/small/".$name, $image->stream()->detach());                                
                
                // добавляю запись в базу       
                $imageRec = new Images();            
                $imageRec->advert_id = $advert_id;
                $imageRec->name = $name;                            
                $imageRec->save();
            }
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {}
}
