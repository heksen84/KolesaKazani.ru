<?php

namespace App\Console\Commands;
use App\Http\Controllers\ApiController;
use Illuminate\Console\Command;
use phpQuery;
use App\Adverts;
use App\CarMark;
use App\CarModel;

class Parse_Kolesa_KZ extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:kolesa_kz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Парсинг объявлений с kolesa.kz';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }


   function getPage($url) {   
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    
    $page = curl_exec($ch); 
    curl_close($ch);
    return $page;
   }

   
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        $doc = phpQuery::newDocument(self::getPage("https://kolesa.kz"));
        $items = $doc->find('.block-links-list')->eq(0)->find("a");

	CarMark::truncate();
	CarModel::truncate();

        foreach($items as $item) { 

	  $carName =  pq($item)->text();
	  $href =  pq($item)->attr("href");

          $carMark = new CarMark();
	  $carMark->name = $carName;
	  $carMark->save();

          $doc = phpQuery::newDocument(self::getPage("https://kolesa.kz".$href));
          $items = $doc->find('.element-group-auto-car-mm-1')->eq(0)->find("option");     


	  $this->info("--------------------------------");
	  $this->info($carName." -> ".$href);
	  $this->info("--------------------------------");

     
	  $markName = "";

          foreach($items as $item) { 

	    if (pq($item)->attr("value")!="")              		
		
	      $markName = pq($item)->text();
          	    
		if ($markName!="") {
	              $carModel = new CarModel();
		      $carModel->mark_id = $carMark->id;
		      $carModel->name = $markName;
  		      $carModel->save();
	              $this->info($markName);
		}
	  }


        }
	

        }
    }