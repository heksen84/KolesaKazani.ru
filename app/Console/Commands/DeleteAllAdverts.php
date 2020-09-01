<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Adverts;
use App\Images;
use App\adex_color;
use App\adex_srochno;
use App\adex_top;
use App\urls;
use App\users;
use App\Transport;
use App\RealEstate;


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

        Adverts::truncate();
        Transport::truncate();
	RealEstate::truncate();        
        
        adex_color::truncate();
        adex_srochno::truncate();
        adex_top::truncate();

        urls::truncate();
        
        Images::truncate();

        // здесь логика        
        $this->info('Все объявления удалены');
    }
}
