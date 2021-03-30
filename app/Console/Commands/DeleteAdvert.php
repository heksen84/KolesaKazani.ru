<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Adverts;
use App\Images;
use App\Urls;
use App\Transport;
use App\RealEstate;
use App\Complaints;
use App\users;
use App\adex_color;
use App\adex_srochno;
use App\adex_top;
use App\Helpers\Common;


class DeleteAdvert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advert:delete {advert_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаление объявления';

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

	$raw = "adverts.id = ".$this->argument("advert_id");

        $images = DB::table("images")->join("adverts", "adverts.id", "=", "images.advert_id")->whereRaw($raw)->get();                    
        
        foreach( $images as $img ) {

            if ($img->storage_id===0) {                    
                    
                if (File::delete(Common::getSmallImagesPath().$img->name)) 
                    $this->info(Common::getSmallImagesPath().$img->name." удалён!");

                    if (File::delete(Common::getNormalImagesPath().$img->name)) 
                        $this->info(Common::getNormalImagesPath().$img->name." удалён!");
            }

            if ($img->storage_id===1) {
                                                                                
                if (Storage::disk('s3')->delete("images/normal/".$img->name))
                    $this->info("images/normal/".$img->name." удалён!");                            
                                
                if (Storage::disk('s3')->delete("images/small/".$img->name))
                    $this->info("images/small/".$img->name." удалён!");
            }
        }	
        
        // native SQL
        $items = DB::delete("DELETE 
            adverts,
            sub_transport, 
            sub_realestate, 
            adex_color, 
            adex_top, 
            adex_srochno, 
            images, 
            urls,
            complaints
            FROM `adverts` 
            LEFT JOIN sub_transport ON adverts.inner_id = sub_transport.id
            LEFT JOIN sub_realestate ON adverts.inner_id = sub_realestate.id
            LEFT JOIN images ON adverts.id = images.advert_id
            LEFT JOIN urls ON adverts.id = urls.advert_id
            LEFT JOIN adex_color ON adex_color.advert_id = adverts.id
            LEFT JOIN adex_srochno ON adex_srochno.advert_id = adverts.id
            LEFT JOIN adex_top ON adex_top.advert_id = adverts.id
            LEFT JOIN complaints ON complaints.advert_id = adverts.id
            WHERE ".$raw
        );
 
        $this->info("Затронуто: ".$items." записей в бд");
    }
}
