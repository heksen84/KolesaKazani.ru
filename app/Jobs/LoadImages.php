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

	    /*
	      	Сохранить в хранилище
		Получить имя сохранённго файла
	    */

	    //$file = request()->file("file");
	    $name = time()."-".$img->getClientOriginalName();
        
        \Storage::disk('s3')->put($name, file_get_contents($img));        
        \Debugbar::info(\Storage::disk('s3')->url($name));

            // добавляю запись в базу       
/*            $imageRec = new Images();            
            $imageRec->advert_id = $advert_id;
            $imageRec->name = $filename;                            
            $imageRec->save();                                    
*/

        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {}
}
