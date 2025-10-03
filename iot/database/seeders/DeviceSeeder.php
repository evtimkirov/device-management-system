<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\User;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $devices = Device::factory()
            ->count(5)
            ->create();

        foreach ($devices as $device) {
            User::all()->random()->devices()->save($device);
        }
    }
}
