<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Categories;
use App\SubCats;
use App\Regions;
use App\Places;
use Carbon\Carbon;

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
	fwrite($file,"<changefreq>daily</changefreq>");
	//fwrite($file,"<priority>0.8</priority>");
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

        $app_url = config('app.url', 'Laravel');
        
        //$date_time = Carbon::now()->format('Y-m-d\TH:i:sP');        
        $date_time = Carbon::now()->format('Y-m-d');        
        $this->info($date_time);
        
        $base1  = fopen("base1.xml", "w");
        $base2  = fopen("base2.xml", "w");
        $base3  = fopen("base3.xml", "w");
        $base4  = fopen("base4.xml", "w");
        $base5  = fopen("base5.xml", "w");
        $base6  = fopen("base6.xml", "w");
        $base7  = fopen("base7.xml", "w");
        $base8  = fopen("base8.xml", "w");
        $base9  = fopen("base9.xml", "w");
        $base10 = fopen("base10.xml", "w");

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

        $total = count($results);

/*	foreach($results as $item1) {
                foreach($results1 as $item2) {
                        $slash_subcats = "";
                         if ($item2->category_url && $item2->subcats_url)	  
                           $slash_subcats = "/";                                               
                           $this->generateRecord($app_url."/".$item1->region_url."/".$item1->place_url."/c/".$item2->category_url.$slash_subcats.$item2->subcats_url, $date_time, $base6);        
  
                       }	  
        }
*/

        fwrite($base7, '<?xml version="1.0" encoding="UTF-8"?>');
        fwrite($base7,'<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">');

        fwrite($base8, '<?xml version="1.0" encoding="UTF-8"?>');
        fwrite($base8,'<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">');

        fwrite($base9, '<?xml version="1.0" encoding="UTF-8"?>');
        fwrite($base9,'<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">');

        fwrite($base10, '<?xml version="1.0" encoding="UTF-8"?>');
        fwrite($base10,'<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">');

        $curIndexFile = $base6;

        $total1 = count($results);
        $total2 = count($results1);        
        
        $nextVal1 = 50;
        $nextVal2 = 200;
        $nextVal3 = 300;
        $nextVal4 = 400;
        
        $this->info($total1);
        $this->info($total2);
        $this->info($nextVal1);

       for($i=0; $i<$total1; $i++) {        

        for($j=0; $j<$total2; $j++) {
                $slash_subcats = "";                
                if ($results1[$j]->category_url && $results1[$j]->subcats_url)	                  
                $slash_subcats = "/";                                               
                $this->generateRecord($app_url."/".$results[$i]->region_url."/".$results[$i]->place_url."/c/".$results1[$j]->category_url.$slash_subcats.$results1[$j]->subcats_url, $date_time, $curIndexFile);                

                //if ($i===(count(results/10%))))) {
                  //      $this->info(count(results)/10%);
                 //       $curIndexFile = $base7;                
                //}
                /*if ($i===$nextVal2) $curIndexFile = $base8;
                if ($i===$nextVal3) $curIndexFile = $base9;
                if ($i===$nextVal4) $curIndexFile = $base10;*/
         }

       }


        fwrite($base6, '</urlset>');
        fclose($base6);

        fwrite($base7, '</urlset>');
        fclose($base7);

        fwrite($base8, '</urlset>');
        fclose($base8);

        fwrite($base9, '</urlset>');
        fclose($base9);

        fwrite($base10, '</urlset>');
        fclose($base10);
                
        $this->info("ready!");
    }
}
