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
    protected $signature = 'sitemap:generatePlacementLinks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Генерировать ссылки размещения по городам для сайтмапа';

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
        
        $places = Places::select("name", "url")->orderBy('name')->distinct()->get();	

	foreach($places as $place) {          
	  fwrite($file, str2url("Подать объявление ".$place->name)."\n");	 		  
        }
        
	foreach($places as $place) {          
	 fwrite($file, str2url("Подать объявление бесплатно ".$place->name)."\n");
	}

	foreach($places as $place) {          
	  fwrite($file, str2url("Разместить объявление ".$place->name)."\n");
	}

	foreach($places as $place) {          
	  fwrite($file, str2url("Разместить объявление бесплатно ".$place->name)."\n");
	}

        fwrite($file, '</urlset>');
        fclose($file);
                        
        $this->info("----------------------");
        $this->info("ok");

    }
}