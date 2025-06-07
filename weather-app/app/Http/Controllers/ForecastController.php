<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ForecastController extends Controller
{
    public function getForecast($city)
    {
        \Log::info("Getting forecast for: $city");
        $supportedCities = [
            'Brisbane' => 'brisbane',
            'Gold Coast' => 'gold+coast',
            'Sunshine Coast' => 'sunshine+coast',
        ];

        if (!isset($supportedCities[$city])) {
            return response()->json(['error' => 'Invalid city'], 400);
        }

        $apiKey = env('e400c74a32a84ac2815f69e932a26e20');
        $citySlug = $supportedCities[$city];
        $url = "https://api.weatherbit.io/v2.0/forecast/daily?city={$citySlug}&days=5&key={$apiKey}";

        $response = Http::get($url);

        if ($response->failed()) {
            return response()->json(['error' => 'API error'], 500);
        }

        $data = collect($response->json('data'))->map(function ($day) {
            return [
                'date' => $day['datetime'],
                'avg' => $day['temp'],
                'max' => $day['max_temp'],
                'min' => $day['min_temp'],
            ];
        });

        return $data;
    }
}
