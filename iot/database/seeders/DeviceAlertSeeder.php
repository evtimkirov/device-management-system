<?php

namespace Database\Seeders;

use App\Models\DeviceAlert;
use Illuminate\Database\Seeder;

class DeviceAlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DeviceAlert::factory()->count(5)->create();
    }
}
