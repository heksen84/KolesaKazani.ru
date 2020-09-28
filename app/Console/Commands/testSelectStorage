<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Images;
                                                                                                                            i
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

	/*CASE
	    WHEN condition1 THEN result1
	    WHEN condition2 THEN result2
	    WHEN conditionN THEN resultN
	    ELSE result
	END;*/

	// вставить case в выборке
	// WITH images AS (select id, title AS name, (SELECT 1) as imgStorageId from `adverts`) SELECT id, concat(name, ' /public/storage/', imgStorageId) AS path FROM images WHERE id = 1
    }
}
