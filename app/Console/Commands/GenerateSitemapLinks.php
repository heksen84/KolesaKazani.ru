<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Categories;
use App\SubCats;
use App\Regions;
use App\Places;

class GenerateSitemapLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:genlinks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Генерировать ссылки сайтмапа по категориям';

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

	$app_url = config('app.url', 'Laravel');

        $this->info("только категории");

	$data = Categories::select("categories.url as category_url")->orderBy('id')->get();	

	foreach($data as $item) {
          $this->info($app_url."/c/".$item->category_url);
	}

        $this->info("категории с подкатегориями");
	
	$data = Categories::select("categories.url as category_url", "subcats.url as subcats_url")->join("subcats", "categories.id", "=", "subcats.category_id" )->orderBy('categories.id')->get();	
	
	foreach($data as $item) {
	 $slash_subcats = "";
	  if ($item->category_url && $item->subcats_url)	  
    	     $slash_subcats = "/";

          $this->info($app_url."/c/".$item->category_url.$slash_subcats.$item->subcats_url);
	}


        $this->info("регионы");

	$regions = Regions::select("url")->orderBy('region_id')->get();	
	foreach($regions as $region) {
	  $this->info($app_url."/".$region->url);
	}

        $this->info("регионы с подкатегориями");

	foreach($regions as $region) {
	foreach($data as $item) {
	  $slash_subcats = "";
 	   if ($item->category_url && $item->subcats_url)	  
    	      $slash_subcats = "/";
    	   
           $this->info($app_url."/".$region->url."/c/".$item->category_url.$slash_subcats.$item->subcats_url);
	 }
	}

/*	$places_and_regions = Places::select("region.url as region_url", "places.url as places_url")->join("regions", "id", "=", "places.region_id")->orderBy('city_id')->get();	
	foreach($places_and_regions as $pa) {
	  $this->info($app_url."/".$pa->region_url."/".$pa->places_url);
	}*/

/*	foreach($regions as $region) {
	 foreach($places as $place) {
	  $this->info($app_url."/".$region->url."/".$place->url);
	 }
	}
*/	



    }
}
