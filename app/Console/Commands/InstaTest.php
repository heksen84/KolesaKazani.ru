<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;

//require_once '/vendor/autoload.php';
//require_once '.\tioffs\src\src.php';

use App\Helpers\InstaLite;

class InstaTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insta:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
	$instagram = new InstaLite("test_site68", "morphosis19");
	$instagram->uploadPhoto(__DIR__ . '/img.jpg', 'text #hashtag');
    }
}
