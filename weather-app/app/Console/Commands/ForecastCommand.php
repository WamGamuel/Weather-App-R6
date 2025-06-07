<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ForecastCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forecast {cities?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show 5 day forecast for given cities';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cities = $this->argument('cities');

        if (empty($cities)) {
            $cities = explode(',', $this->ask('Enter cities separated by commas'));
        }

        foreach ($cities as $city) {
            $this->info("Forecast for $city:");
            $response = Http::get('https://api.weatherbit.io/v2.0/forecast/daily', [
                'city' => $city,
                'key' => env('e400c74a32a84ac2815f69e932a26e20'),
            ]);

            if (!$response->ok()) {
                $this->error("Could not get forecast for $city");
                continue;
            }

            $data = $response->json()['data'];
            $tableData = collect($data)->take(5)->map(fn($d) => [
                $d['datetime'],
                ($d['min_temp'] + $d['max_temp']) / 2,
                $d['min_temp'],
                $d['max_temp']
            ]);

            $this->table(['Date', 'Avg Temp', 'Min Temp', 'Max Temp'], $tableData);
        }
    }
}
