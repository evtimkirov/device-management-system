<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Measurement>
 */
class MeasurementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'device_id'   => DB::table('devices')->inRandomOrder()->value('id'),
            'temperature' => $this->faker->numberBetween(-20, 50),
            'measured_at' => $this->faker->dateTime(),
        ];
    }
}
