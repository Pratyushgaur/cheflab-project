<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RiderIncentive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'incentive:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command will generate incentive';

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
     * @return int
     */
    public function handle()
    {
        \App\Jobs\RiderIncentiveJob::dispatch();
        echo 'Incentive Generated';
    }
}
