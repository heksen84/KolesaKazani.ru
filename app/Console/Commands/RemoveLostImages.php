<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Jobs\DeleteImages;
use App\Jobs\DeleteImagesFromCloud;
use App\Helpers\Common;
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
                        
            $imagesArray = [];

            foreach($images->get() as $img) {
                            
                $arrayRecord = array("path" => storage_path().Common::SMALL_IMAGES_LOCAL_PATH, "name" => $img->name, "type" => "normal");
                array_push($imagesArray, $arrayRecord);                
                
                $arrayRecord = array("path" => storage_path().Common::NORMAL_IMAGES_LOCAL_PATH, "name" => $img->name, "type" => "small");
                array_push($imagesArray, $arrayRecord);                                                                
            }

            // Удаляю картинки из облачного хранилища
            DeleteImagesFromCloud::dispatch($imagesArray);

            // Удаляю картинки из хранилища на локальном диске
            DeleteImages::dispatch($imagesArray);

            // удаляю изображение из таблицы
            $images->delete();

            $this->info("выполнено (executed)");

        }
        else 
            $this->info("нет потерянных изображений (NoLostImages)");
    }
}
