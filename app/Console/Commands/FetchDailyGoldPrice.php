<?php

namespace App\Console\Commands;

use App\Services\MetalPriceService;
use Illuminate\Console\Command;

class FetchDailyGoldPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gold:fetch-daily-price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and store daily gold price from Metal Price API';

    /**
     * Execute the console command.
     */
    public function handle(MetalPriceService $service)
    {
        $this->info('Fetching daily gold price...');

        $prices = $service->getGoldPrices();

        if ($prices) {
            $this->info('Successfully fetched and stored gold price:');
            $this->line('MYR per gram: RM'.number_format($prices['gram_MYR'], 2));
            $this->line('MYR per ounce: RM'.number_format($prices['MYR'], 2));

            return Command::SUCCESS;
        }

        $this->error('Failed to fetch gold price. Check logs for details.');

        return Command::FAILURE;
    }
}
