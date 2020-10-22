<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Helpers\Common;
use App\Images;

class DeleteAllImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:deleteAll';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаление всех изображений из хранилища';

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

	if( $this->confirm('Удалить все изображения? (yes|no)[no]')) {
        
        if( $this->confirm('Вы действительно уверены? Это удалит все изображения! (yes|no)[no]')) {

	    foreach(Images::all() as $img) {
                        
            if ($img->storage_id===0) {                    
                    
                if (File::delete(Common::SMALL_IMAGES_LOCAL_STORAGE_PATH.$img->name)) 
                    $this->info(Common::SMALL_IMAGES_LOCAL_STORAGE_PATH.$img->name." удалён!");

                    if (File::delete(Common::NORMAL_IMAGES_LOCAL_STORAGE_PATH.$img->name)) 
                        $this->info(Common::NORMAL_IMAGES_LOCAL_STORAGE_PATH.$img->name." удалён!");
            }

            if ($img->storage_id===1) {
                                                                                
                if (Storage::disk('s3')->delete("images/normal/".$img->name))
                    $this->info("images/normal/".$img->name." удалён!");                            
                                
                if (Storage::disk('s3')->delete("images/small/".$img->name))
                    $this->info("images/small/".$img->name." удалён!");
            }
                        
        }	

        Images::truncate();       
        $this->info('Все изображения удалены');

        }

       }
    }
}
