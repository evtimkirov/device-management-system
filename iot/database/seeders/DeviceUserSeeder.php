<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\User;
use Illuminate\Database\Seeder;

class DeviceUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Device::all() as $device) {
            $randomUser = User::inRandomOrder()->first();
            $device->users()->attach($randomUser->id);
        }
    }
}
