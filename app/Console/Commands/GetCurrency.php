<?php

namespace App\Console\Commands;

use App\Services\CurrencyService;
use Illuminate\Console\Command;
use GuzzleHttp\Client;

class GetCurrency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:currency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update currencies';

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
    public function handle(CurrencyService $service)
    {
        $this->info('Updating currencies!');
//        $this->info('Updating currencies!');
        try{
            $service->update();
            $this->info('Updated');
        }catch (\Exception $e){
            $this->info($e->getMessage());
            return;
        }
    }
}
