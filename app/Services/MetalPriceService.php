<?php

namespace App\Services;

use App\Models\GoldPrice;
use App\Models\ProfitMargin;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MetalPriceService
{
    protected $apiKey;

    protected $baseUrl = 'https://api.metalpriceapi.com/v1/latest';

    public function __construct()
    {
        $this->apiKey = env('MENTAL_PRICE_API');
    }

    public function getGoldPrices()
    {
        try {
            $response = Http::get($this->baseUrl, [
                'api_key' => $this->apiKey,
                'base' => 'USD',
                'currencies' => 'XAU,MYR',
            ]);

            if ($response->successful()) {

                $data = $response->json();

                // Check if rates exist
                if (! isset($data['rates']['XAU']) || ! isset($data['rates']['MYR'])) {
                    Log::error('MetalPriceAPI: Rates not found in response', $data);

                    return null;
                }

                $rates = $data['rates'];
                $xauUsd = 1 / $rates['XAU']; // Price of 1 oz Gold in USD
                $myrRate = $rates['MYR']; // USD to MYR rate
                $xauMyr = $xauUsd * $myrRate; // Price of 1 oz Gold in MYR

                // Calculate price per gram (1 oz = 31g)
                $gramUsd = $xauUsd / 31;
                $gramMyr = $xauMyr / 31;

                // Store daily price in database
                $this->storeDailyPrice($xauMyr, $gramMyr);

                // Get profit margins from database
                $staffMargin = ProfitMargin::where('name', 'Staff')->first();
                $agentMargin = ProfitMargin::where('name', 'Agent')->first();

                // Calculate margins using database values
                $gramMyrStaff = $staffMargin ? $gramMyr * $staffMargin->getMultiplier() : $gramMyr * 1.005;
                $gramMyrAgent = $agentMargin ? $gramMyr * $agentMargin->getMultiplier() : $gramMyr * 1.03;

                // Calculate profit
                $profitStaff = $gramMyrStaff - $gramMyr;
                $profitAgent = $gramMyrAgent - $gramMyr;

                return [
                    'USD' => $xauUsd,
                    'MYR' => $xauMyr,
                    'gram_USD' => $gramUsd,
                    'gram_MYR' => $gramMyr,
                    'gram_MYR_staff' => $gramMyrStaff,
                    'gram_MYR_agent' => $gramMyrAgent,
                    'profit_staff' => $profitStaff,
                    'profit_agent' => $profitAgent,
                    'timestamp' => $data['timestamp'] ?? now()->timestamp,
                ];
            }

            Log::error('MetalPriceAPI Error: '.$response->body());

            return null;
        } catch (\Exception $e) {
            Log::error('MetalPriceService Exception: '.$e->getMessage());

            return null;
        }
    }

    /**
     * Store daily gold price in database (only once per day)
     */
    protected function storeDailyPrice($pricePerOunce, $pricePerGram)
    {
        // Check if we already have a price for today
        $existingPrice = GoldPrice::where('currency', 'MYR')
            ->whereDate('created_at', today())
            ->exists();

        if (! $existingPrice) {
            GoldPrice::create([
                'price_per_troy_ounce' => $pricePerOunce,
                'price_per_gram' => $pricePerGram,
                'currency' => 'MYR',
                'source' => 'Metal Price API',
                'created_at' => now(),
            ]);

            Log::info('Stored daily gold price', [
                'price_per_ounce' => $pricePerOunce,
                'price_per_gram' => $pricePerGram,
            ]);
        }
    }

    /**
     * Get today's stored gold price
     */
    public function getTodayPrice()
    {
        return GoldPrice::where('currency', 'MYR')
            ->whereDate('created_at', today())
            ->first();
    }

    /**
     * Get historical gold prices (latest N records)
     */
    public function getHistoricalPrices($limit = 5)
    {
        return GoldPrice::where('currency', 'MYR')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get latest stored gold price
     */
    public function getLatestStoredPrice()
    {
        return GoldPrice::where('currency', 'MYR')
            ->latest('created_at')
            ->first();
    }
}
