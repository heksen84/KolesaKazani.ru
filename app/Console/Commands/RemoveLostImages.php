<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Jobs\DeleteTempImages;
use App\Jobs\DeleteImagesFromCloud;
use App\Images;

class RemoveLostImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:removeLost';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаление потерянных изображений';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        $images = Images::select("name")->where("advert_id", null);

        if (count($images->get()) > 0) {
                        
            foreach($images->get() as $img) {

                $imagesArray = [];

                $normalFileNamePath = storage_path().'/app/images/normal/';                        
                $arrayRecord = array("path" => $normalFileNamePath, "name" => $img->name, "type" => "normal");
                array_push($imagesArray, $arrayRecord);                

                $smallFileNamePath = storage_path().'/app/images/small/';        
                $arrayRecord = array("path" => $smallFileNamePath, "name" => $img->name, "type" => "small");
                array_push($imagesArray, $arrayRecord);                                                

                // Удаляю картинки из облачного хранилища
                DeleteImagesFromCloud::dispatch($imagesArray);

                // Удаляю картинки из хранилища на локальном диске
                DeleteTempImages::dispatch($imagesArray);

                // удаляю изображение из таблицы
                $images->delete();

                $this->info("выполнено (executed)");
            }
        }
        else 
            $this->info("нет потерянных изображений (NoLostImages)");
    }
}
