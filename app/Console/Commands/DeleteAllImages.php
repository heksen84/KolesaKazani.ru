<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Images;



/*
    удалить объявление которое просрочено на месяц и всё что с ним связано: подкатегории и картинки в хранилище
*/

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
            
            $this->info($img);
            
            if (\Storage::delete("images/normal/".$img->name)) {
                $this->info("images/normal/".$img->name." удалён!");                            
            }
            
            if (\Storage::delete("images/small/".$img->name)) {
                $this->info("images/small/".$img->name." удалён!");                            
            }
        }	

            //Images::truncate();       
            $this->info('Все изображения удалены');
        }

       }
    }
}
