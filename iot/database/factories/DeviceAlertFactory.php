<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\Measurement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeviceAlert>
 */
class DeviceAlertFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::has('devices')->inRandomOrder()->first();

        // Create device with user if not exists
        if (!$user) {
            $user = User::factory()
                ->has(Device::factory()
                    ->has(Measurement::factory()->count(5))
                    ->count(1))
                ->create();
        }

        $device = $user->devices()->inRandomOrder()->first();
        $measurement = $device->measurements()->inRandomOrder()->first();

        return [
            'device_id'      => $device->id,
            'measurement_id' => $measurement->id,
            'type'           => $this->faker->randomElement(['temperature_threshold', 'offline', 'custom_rule']),
            'message'        => "Temperature {$measurement->temperature}°C is out of safe range (0–30).",
        ];
    }
}
