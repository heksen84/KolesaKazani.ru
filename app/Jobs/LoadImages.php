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

class LoadImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Request $request, $advert_id)
    {
        if ($request->images)
        foreach($request->file("images") as $img) {

            $filename = str_random(32).".".$img->getClientOriginalExtension();
            $image_resize = Image::make($img->getRealPath());
            
            // изменяю размер с соотношением пропорций
            $image_resize->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
            });

            // пишу текст в картинку
            $image_resize->text(env("APP_URL"), 8,25, function($font) {
                $font->file(public_path()."/fonts/Brushie.ttf");
                $font->color(array(255,255,255,1));
                $font->size(26);
            });

            // ... и сохраняю в хранилище
            $image_resize->save(storage_path().'/app/images/' .$filename);
            $image = new Images();
            $image->advert_id = $advert_id;
            $image->image = $filename;                
            $image->save();
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
