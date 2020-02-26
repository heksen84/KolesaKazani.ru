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

            // формирую рандомное имя
            $filename = str_random(32).".".$img->getClientOriginalExtension();
            
            // узнаю имя
            $imageName = Image::make($img->getRealPath());            
            $imageName->save(storage_path().'/app/images/normal/' .$filename);
            
            // добавляю запись в базу       
            $image = new Images();            
            $image->advert_id = $advert_id;
            $image->name = $filename;                
            $image->type = 1; // 1 = normal (тип normal)
            $image->save();
            
            // изменяю размер с соотношением пропорций
            $imageName->resize(200, 150, function ($constraint) {
                $constraint->aspectRatio();
            });
            
            $imageName->save(storage_path().'/app/images/small/' .$filename);                        

            // добавляю запись в базу
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
