<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\SE_UserQueries;

class ImportUserQueries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:userqueries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Импорт запросов пользователя из файла';

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

if ($file = fopen("storage\data\words.txt", "r")) {
    while(!feof($file)) {
        $line = fgets($file);
	   $record = new SE_UserQueries();
	   $record->title = $line;
	   $record->region_id = 0;
	   $record->place_id = 0;
	   $record->category_id = 0;
	   $record->subcategory_id = 0;
	   $record->optype = 0;
	   $record->save();

    }
    fclose($file);
}

    }
}
