<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Adverts;
use App\Images;
use App\Urls;
use App\Transport;
use App\RealEstate;
use App\users;
use App\adex_color;
use App\adex_srochno;
use App\adex_top;


/*
    удалить объявление которое просрочено на месяц и всё что с ним связано: подкатегории и картинки в хранилище
*/

class DeleteExpiredAdverts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adverts:deleteExpired';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удалить просроченные объявления';

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
    
        /*$items = DB::table("adverts as adv", "adex_top", '00')
        ->leftJoin("sub_transport", "adv.inner_id" , "=" , "sub_transport.id" )
        ->leftJoin("sub_realestate", "adv.inner_id" , "=" , "sub_realestate.id" )
        ->leftJoin("images", "adv.id" , "=" , "images.id" )
        ->leftJoin("urls", "adv.id" , "=" , "urls.advert_id" )        
        ->leftJoin("adex_color", "adv.id" , "=" , "adex_color.advert_id" )
        ->leftJoin("adex_srochno", "adv.id" , "=" , "adex_srochno.advert_id" )
        ->leftJoin("adex_top", "adv.id" , "=" , "adex_top.advert_id" )
        ->whereRaw("adv.finishDate + INTERVAL -30 DAY >= NOW()")
        ->whereRaw("adex_srochno.advert_id = adv.id")
        ->whereRaw("adex_top.advert_id = adv.id")
        ->delete();*/

        $images = DB::table("images")->join("adverts", "adverts.id", "=", "images.advert_id")->whereRaw("adverts.finishDate + INTERVAL 30 DAY >= NOW()")->get();        
        $this->info($images);
        
        foreach( $images as $img ) {

            $this->info("----------------------------------------------------------------------");          
            
            if (Storage::disk('s3')->delete("images/normal/".$img->name)) {
                $this->info("images/normal/".$img->name." удалён!");                            
            }
            
            if (Storage::disk('s3')->delete("images/small/".$img->name)) {
                $this->info("images/small/".$img->name." удалён!");                            
            }
            $this->info("----------------------------------------------------------------------\n");

        }	
        
        $items = DB::delete("DELETE 
            adverts,
            sub_transport, 
            sub_realestate, 
            adex_color, 
            adex_top, 
            adex_srochno, 
            images, 
            urls 
            FROM `adverts` 
            LEFT JOIN sub_transport ON adverts.inner_id = sub_transport.id
            LEFT JOIN sub_realestate ON adverts.inner_id = sub_realestate.id
            LEFT JOIN images ON adverts.id = images.advert_id
            LEFT JOIN urls ON adverts.id = urls.advert_id
            LEFT JOIN adex_color ON adex_color.advert_id = adverts.id
            LEFT JOIN adex_srochno ON adex_srochno.advert_id = adverts.id
            LEFT JOIN adex_top ON adex_top.advert_id = adverts.id
            WHERE adverts.finishDate + INTERVAL 30 DAY >= NOW()"
        );
 
        $this->info("Удалено: ".$items." записей");

    }
}
