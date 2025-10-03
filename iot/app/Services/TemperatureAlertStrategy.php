<?php

namespace App\Services;

use App\Models\Measurement;

class TemperatureAlertStrategy implements AlertStrategy
{
    public function check(Measurement $measurement): ?array
    {
        if ($measurement->temperature < 0 || $measurement->temperature > 30) {
            return [
                'type'    => 'temperature_threshold',
                'message' => "Temperature {$measurement->temperature}°C is out of safe range (0–30).",
            ];
        }

        return null;
    }
}
