<?php

namespace Database\Seeders;

use App\Models\Measurement;
use App\Services\DeviceAlertService;
use Illuminate\Database\Seeder;

class MeasurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $measurements = Measurement::factory()->count(50)->create();
        $alertService = app(DeviceAlertService::class);

        foreach ($measurements as $measurement) {
            $alertService->checkAndCreateAlert($measurement);
        }
    }
}
