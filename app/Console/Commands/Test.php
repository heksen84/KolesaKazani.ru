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
    	$this->info("Минимальный объём места: ".Common::MIN_FREE_DISK_SPACE_IN_GB);
	    $this->info("Свободно: ".Common::getFreeDiskSpace(".")." гигабайта");
    }
}
