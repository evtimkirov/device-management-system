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
        // User with device
        $user = User::has('devices')->inRandomOrder()->first();

        // Create device with user if not exists
        if (!$user) {
            $user = User::factory()
                ->has(Device::factory()
                    ->has(Measurement::factory()->count(5))
                    ->count(1))
                ->create();
        }

        // Random device
        $device = $user->devices()->inRandomOrder()->first();

        // Measurement for the selected device
        $measurementId = $device->measurements()->inRandomOrder()->first()->id;

        return [
            'device_id'      => $device->id,
            'measurement_id' => $measurementId,
            'type'           => $this->faker->randomElement(['temperature_threshold', 'offline', 'custom_rule']),
            'message'        => $this->faker->text(),
        ];
    }
}
