<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\Common;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Тест общего назначения. Для обкатки всякой ерунды.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
//    	$this->info("Минимальный объём места: ".Common::MIN_FREE_DISK_SPACE_IN_GB);
//	    $this->info("Свободно: ".Common::getFreeDiskSpace(".")." гигабайта");

//	    $x = newValue.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);            
//            $val = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : ''); 
	   
            $phone = "7058675457";

	    $res = "(".$phone[0].$phone[1].$phone[2].")".$phone[3].$phone[4].$phone[5].$phone[6].$phone[7].$phone[8].$phone[9];
 	    $this->info($res);

    }
}
