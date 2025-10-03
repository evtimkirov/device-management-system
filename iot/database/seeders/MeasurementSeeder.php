<?php

namespace Database\Seeders;

use App\Models\Measurement;
use App\Services\AlertManager;
use Illuminate\Database\Seeder;

class MeasurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(AlertManager $alertManager): void
    {
        foreach (Measurement::factory()->count(50)->create() as $measurement) {
            $alertManager->checkAndCreateAlerts($measurement);
        }
    }
}
