<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateSitemapLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:genlinks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Генерировать ссылки сайтмапа по категориям';

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
        $this->info("привет!");
    }
}
