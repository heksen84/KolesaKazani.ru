<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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

class DeleteAllAdverts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adverts:deleteAll';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаление всех объявлений';

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

	if( $this->confirm('Удалить все объявления? (yes|no)[no]')) {
        if( $this->confirm('Вы действительно уверены? Это удалит все объявления! (yes|no)[no]')) {

            Adverts::truncate();
            Transport::truncate();
	        RealEstate::truncate();        
            Urls::truncate();        
            Images::truncate();
        
            adex_color::truncate();
            adex_srochno::truncate();
            adex_top::truncate();

            // здесь логика        
            $this->info('Все объявления удалены');
        }

       }
    }
}
