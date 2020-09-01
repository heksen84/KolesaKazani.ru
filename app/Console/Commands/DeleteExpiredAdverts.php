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

        /*
            1. грохнуть запись с adverts
            2. грохнуть запись с подкатегории если это транспорт или недвижимость
            3. грохнуть запись с urls
            4. грохнуть запись с adex_color
            5. грохнуть запись с adex_srochno
            6. грохнуть запись с adex_top
            7. грохнуть запись с images
        */

        /*

        Adverts::truncate();
        Transport::truncate();
	    RealEstate::truncate();        
        Urls::truncate();        
        Images::truncate();
        
        adex_color::truncate();
        adex_srochno::truncate();
        adex_top::truncate();*/

        // здесь логика        
        $this->info('Временные объявления удалены');
    }
}
