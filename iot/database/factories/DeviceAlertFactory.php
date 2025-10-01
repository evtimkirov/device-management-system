<?php

namespace Database\Factories;

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
        return [
            'device_id'      => DB::table('devices')->inRandomOrder()->value('id'),
            'measurement_id' => DB::table('measurements')->inRandomOrder()->value('id'),
            'type'           => $this->faker->randomElement(['temperature_threshold', 'offline', 'custom_rule']),
            'message'        => $this->faker->text(),
        ];
    }
}
