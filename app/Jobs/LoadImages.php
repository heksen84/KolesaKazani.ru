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

        if ($request->images)

        // бегу по картинкам
        foreach($request->file("images") as $img) {

            // формирую имя
            $filename = str_random(32).".".$img->getClientOriginalExtension();

            // узнаю имя
            $image_resize = Image::make($img->getRealPath());
            
            // изменяю размер с соотношением пропорций
            $image_resize->resize(200, 150, function ($constraint) {
                $constraint->aspectRatio();
            });

            // сохраняю в хранилище
            $image_resize->save(storage_path().'/app/images/preview/' .$filename);
            
            $image = new Images();

            $image->advert_id = $advert_id;
            $image->name = $filename;                
            $image->type = 0; // 0 = small (тип preview)

            $image->save();
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {}
}
