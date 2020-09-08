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

        /*
                - категории
                - категории с подкатегориями
                - регионы
                - города ???
                - регионы с категориями (делать!)
                - регионы с подкатегориями (делать!)
                - регион+город с категориями (делать!)
                - регионы+город с подкатегориями (делать!)

        */
        
	$app_url = config('app.url', 'Laravel');

        $this->info('<?xml version="1.0" encoding="UTF-8"?>');
        
        $this->info("<!-- только категории -->");

        $categories = Categories::select("url")->orderBy('url')->get();	

	foreach($categories as $category) {
          $this->info('<url>');                
          $this->info("<loc>".$app_url."/c/".$category->url."</loc>");
          $this->info("<changefreq>hourly</changefreq>");
          $this->info("<priority>0.8</priority>");
          $this->info('</url>');
	}

        $this->info("<!-- категории с подкатегориями -->");
	
	$results1 = Categories::select("categories.url as category_url", "subcats.url as subcats_url")->leftJoin("subcats", "categories.id", "=", "subcats.category_id" )->distinct('subcats.url')->orderBy('categories.url')->orderBy('subcats.url')->get();	
	
	foreach($results1 as $item) {
	 $slash_subcats = "";
	  if ($item->category_url && $item->subcats_url)	  
    	     $slash_subcats = "/";

          $this->info($app_url."/c/".$item->category_url.$slash_subcats.$item->subcats_url);
	}

        $this->info("<!-- регионы -->");

	$regions = Regions::select("url")->orderBy('kz_region.url')->get();	
	foreach($regions as $region) {
	  $this->info($app_url."/".$region->url);
        }

        $this->info("<!-- регионы c городами-->");
        
        $results = Regions::select("kz_region.url as region_url", "kz_city.url as place_url")->leftJoin("kz_city", "kz_city.region_id", "=", "kz_region.region_id")->orderBy('kz_region.url')->orderBy('kz_city.url')->orderBy('kz_region.url')->get();	
	foreach($results as $item) {
	  $this->info($app_url."/".$item->region_url."/".$item->place_url);
        }

        $this->info("<!-- регионы c городами и категориями-->");

        foreach($categories as $category) {
        foreach($results as $item) {                
                 $this->info($app_url."/".$item->region_url."/".$item->place_url."/c/".$category->url);
          }
        }

        $this->info("<!-- регионы c городами и категориями и подкатегориями где???-->");
        
        $this->info('</urlset>');

    }
}
