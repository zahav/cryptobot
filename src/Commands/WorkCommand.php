<?php

namespace Zahav\ZahavLaravel\Commands;

use Illuminate\Console\Command;
use Zahav\ZahavLaravel\Facades\Zahav;

class WorkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zahav:work';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the crypto trading bot';

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
    public function handle()
    {
        Zahav::start();

        $this->info('Starting the crypto trading bot...');
    }
}