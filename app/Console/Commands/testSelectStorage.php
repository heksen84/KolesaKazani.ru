<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Images;

class testSelectStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:selectStorageId';
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

	// нужно передать imgStorageId в СOMMON::getImagesPath()
	//WITH result AS (select title AS name, (SELECT 1) as imgStorageId from `adverts`) SELECT concat(name, '----', imgStorageId) FROM result
    }
}
