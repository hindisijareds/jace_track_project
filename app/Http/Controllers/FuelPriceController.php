<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class FuelPriceController extends Controller
{
    public function getDieselPrice()
    {
        // Fetch DOE Oil Monitor page
        $html = Http::get('https://www.doe.gov.ph/oil-monitor')->body();

        // Find the Diesel price adjustment from the page
        preg_match('/Diesel.*?([+\-]?\s*₱?\d+(\.\d+)?)/i', $html, $matches);

        $adjustment = $matches[1] ?? '₱0.00';

        // Base reference diesel price (example)
        $basePrice = 54.00;

        // Extract numeric adjustment (e.g. "+₱0.85" → 0.85)
        $numericAdj = floatval(str_replace(['₱', '+', ' '], '', $adjustment));

        // Compute the current diesel price
        $currentPrice = $basePrice + $numericAdj;

        return response()->json([
            'diesel_price' => round($currentPrice, 2),
            'source' => 'DOE Oil Monitor',
            'adjustment' => $adjustment,
            'url' => 'https://www.doe.gov.ph/oil-monitor'
        ]);
    }
}
