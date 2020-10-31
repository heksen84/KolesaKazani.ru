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

    public function generateRecord($url, $date_time, $file) {
            
	fwrite($file, '<url>');                
	fwrite($file,"<loc>".$url."</loc>");
	fwrite($file,"<lastmod>".$date_time."</lastmod>");
	fwrite($file,"<changefreq>hourly</changefreq>");
	fwrite($file,"<priority>0.8</priority>");
	fwrite($file,'</url>');
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
        
	$date_time = date("Y-m-dTh:m:s");	
	$app_url = config('app.url', 'Laravel');
        
        $base1 = fopen("base1.xml", "w");
        $base2 = fopen("base2.xml", "w");
        $base3 = fopen("base3.xml", "w");
        $base4 = fopen("base4.xml", "w");
        $base5 = fopen("base5.xml", "w");
        $base6 = fopen("base6.xml", "w");

        // ----------------------------------------------------------------------------

	fwrite($base1, '<?xml version="1.0" encoding="UTF-8"?>');
        fwrite($base1,'<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">');
        
        $categories = Categories::select("url")->orderBy('url')->get();	

	foreach($categories as $category) {          
          $this->generateRecord($app_url."/c/".$category->url, $date_time, $base1);
        }
        
        fwrite($base1, '</urlset>');
        fclose($base1);
        
        // ----------------------------------------------------------------------------

        fwrite($base2, '<?xml version="1.0" encoding="UTF-8"?>');
        fwrite($base2,'<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">');

	$results1 = Categories::select("categories.url as category_url", "subcats.url as subcats_url")->leftJoin("subcats", "categories.id", "=", "subcats.category_id" )->distinct('subcats.url')->orderBy('categories.url')->orderBy('subcats.url')->get();		

	foreach($results1 as $item) {
	   $slash_subcats = "";          
           if ($item->category_url && $item->subcats_url)	  
    	     $slash_subcats = "/";                
             $this->generateRecord($app_url."/c/".$item->category_url.$slash_subcats.$item->subcats_url, $date_time, $base2);
        }
        
        fwrite($base2, '</urlset>');
        fclose($base2);

        // ----------------------------------------------------------------------------

        fwrite($base3, '<?xml version="1.0" encoding="UTF-8"?>');
        fwrite($base3,'<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">');

	$regions = Regions::select("url")->orderBy('kz_region.url')->get();        

        foreach($regions as $region) {
          $this->generateRecord($app_url."/".$region->url, $date_time, $base3);
        }

        fwrite($base3, '</urlset>');
        fclose($base3);

        // ----------------------------------------------------------------------------

        fwrite($base4, '<?xml version="1.0" encoding="UTF-8"?>');
        fwrite($base4,'<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">');

        $results = Regions::select("kz_region.url as region_url", "kz_city.url as place_url")->leftJoin("kz_city", "kz_city.region_id", "=", "kz_region.region_id")->orderBy('kz_region.url')->orderBy('kz_city.url')->orderBy('kz_region.url')->get();	

	foreach($results as $item) {                
          $this->generateRecord($app_url."/".$item->region_url."/".$item->place_url, $date_time, $base4);
        }

        fwrite($base4, '</urlset>');
        fclose($base4);

        // ----------------------------------------------------------------------------

        fwrite($base5, '<?xml version="1.0" encoding="UTF-8"?>');
        fwrite($base5,'<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">');

        foreach($categories as $category) {
         foreach($results as $item) {
            $this->generateRecord($app_url."/".$item->region_url."/".$item->place_url."/c/".$category->url, $date_time, $base5);
          }
        }

        fwrite($base5, '</urlset>');
        fclose($base5);

        // ----------------------------------------------------------------------------

        fwrite($base6, '<?xml version="1.0" encoding="UTF-8"?>');
        fwrite($base6,'<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">');

	foreach($results as $item1) {
                foreach($results1 as $item2) {
                        $slash_subcats = "";
                         if ($item2->category_url && $item2->subcats_url)	  
                           $slash_subcats = "/";                                               
                           $this->generateRecord($app_url."/".$item1->region_url."/".$item1->place_url."/c/".$item2->category_url.$slash_subcats.$item2->subcats_url, $date_time, $base6);        
                       }	  
        }

        fwrite($base6, '</urlset>');
        fclose($base6);
        

        $this->info("ready!");
    }
}
