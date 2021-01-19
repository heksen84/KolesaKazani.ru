<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Categories;
use App\SubCats;
use App\Regions;
use App\Places;
use Carbon\Carbon;

class GenerateSitemapPlace extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:genSitemapPlace';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Генерировать ссылки на размещение';

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


        $app_url = config('app.url', 'Laravel');

        $date_time = Carbon::now()->format('Y-m-d');        

        $this->info($date_time);
        
        $file  = fopen("razmeshenye.xml", "w");

	fwrite($file, '<?xml version="1.0" encoding="UTF-8"?>');
        fwrite($file,'<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">');
        
        $places = Places::select("name")->orderBy('name')->get();	

	foreach($places as $place) {          
          $this->generateRecord($app_url."/c/".$category->url, $date_time, $base1);
        }
        
        fwrite($file, '</urlset>');
        fclose($file);
        
                
        $this->info("ok");
    }
}
