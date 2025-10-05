<?php

namespace Database\Seeders;

use App\Events\MeasurementCreated;
use App\Models\Measurement;
use Illuminate\Database\Seeder;

class MeasurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Measurement::factory()->count(50)->create() as $measurement) {
            MeasurementCreated::dispatch($measurement);
        }
    }
}
