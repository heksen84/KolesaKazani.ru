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

    public function generateRecord($url) {

	$date_time = date("Y-m-dTh:m:s");
            
        $this->info('<url>');                
        $this->info("<loc>".$url."</loc>");
        $this->info("<lastmod>".$date_time."</lastmod>");
        $this->info("<changefreq>hourly</changefreq>");
        $this->info("<priority>0.8</priority>");
        $this->info('</url>');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        /*
                - категории
                - категории + подкатегории
                - регионы
                - регионы + города
                - регионы + категории
                - регионы + подкатегории
                - регионы + города + категории
                - регионы + города + подкатегории
        */
        
	$app_url = config('app.url', 'Laravel');

        $this->info('<?xml version="1.0" encoding="UTF-8"?>');
        $this->info('<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">');
        
        $this->info("<!-- только категории -->");
        $categories = Categories::select("url")->orderBy('url')->get();	
	foreach($categories as $category) {          
          $this->generateRecord($app_url."/c/".$category->url);
	}

        $this->info("<!-- категории с подкатегориями -->");	
	$results1 = Categories::select("categories.url as category_url", "subcats.url as subcats_url")->leftJoin("subcats", "categories.id", "=", "subcats.category_id" )->distinct('subcats.url')->orderBy('categories.url')->orderBy('subcats.url')->get();		
	foreach($results1 as $item) {
	   $slash_subcats = "";          
           if ($item->category_url && $item->subcats_url)	  
    	     $slash_subcats = "/";                
             $this->generateRecord($app_url."/c/".$item->category_url.$slash_subcats.$item->subcats_url);
	}

        $this->info("<!-- регионы -->");
	$regions = Regions::select("url")->orderBy('kz_region.url')->get();        
        foreach($regions as $region) {
          $this->generateRecord($app_url."/".$region->url);
        }

        $this->info("<!-- регионы c городами -->");        
        $results = Regions::select("kz_region.url as region_url", "kz_city.url as place_url")->leftJoin("kz_city", "kz_city.region_id", "=", "kz_region.region_id")->orderBy('kz_region.url')->orderBy('kz_city.url')->orderBy('kz_region.url')->get();	
	foreach($results as $item) {                
          $this->generateRecord($app_url."/".$item->region_url."/".$item->place_url);
        }

        $this->info("<!-- регионы c городами и категориями -->");
        foreach($categories as $category) {
         foreach($results as $item) {
            $this->generateRecord($app_url."/".$item->region_url."/".$item->place_url."/c/".$category->url);
          }
        }

        $this->info("<!-- регионы c городами и категориями и подкатегориями -->");                
	foreach($results as $item1) {
                foreach($results1 as $item2) {
                        $slash_subcats = "";
                         if ($item2->category_url && $item2->subcats_url)	  
                           $slash_subcats = "/";                                               
                           $this->generateRecord($app_url."/".$item1->region_url."/".$item1->place_url."/c/".$item2->category_url.$slash_subcats.$item2->subcats_url);        
                       }	  
        }
        
        $this->info('</urlset>');
    }
}
