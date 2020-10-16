<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\Common;
use App\Images;
use Illuminate\Support\Facades\DB;

class TestImagesStorage extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:imagesStorage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Тестирование хранилища изображений';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        /*$items = DB::table("adverts as adv")->select(
            "urls.url",
            "adv.id", 
            "adv.title", 
            "adv.price",
            "adv.startDate",            
            "kz_region.name as region_name",
            "kz_city.name as city_name",
            DB::raw("(SELECT COUNT(*) FROM adex_color WHERE NOW() BETWEEN adex_color.startDate AND adex_color.finishDate AND adex_color.advert_id=adv.id) as color"),                        
            DB::raw("(SELECT COUNT(*) FROM adex_srochno WHERE NOW() BETWEEN adex_srochno.startDate AND adex_srochno.finishDate AND adex_srochno.advert_id=adv.id) as srochno"),
            DB::raw("concat('".Common::getImage()."/small/', (SELECT name FROM images WHERE images.advert_id=adv.id LIMIT 1)) as imageName"))
            ->leftJoin("adex_color", "adv.id", "=", "adex_color.advert_id" )
            ->leftJoin("adex_srochno", "adv.id", "=", "adex_srochno.advert_id" )			                    
            ->join("urls", "adv.id", "=", "urls.advert_id" )
            ->join("kz_region", "adv.region_id", "=", "kz_region.region_id" )
            ->join("kz_city", "adv.city_id", "=", "kz_city.city_id" )                
            ->whereRaw($whereRaw)            
            ->paginate(10)
            ->onEachSide(1);*/

                                                                                                                                
       //SELECT concat(url,"/", name) FROM `images` INNER JOIN storages ON storages.id = images.storage_id
//       $this->info(DB::raw("WITH table AS (SELECT storage_id FROM images) SELECT * FROM table"));
	$this->info(Common::getImage("small"));

   }

}