<?php

namespace App\Services;

use App\Models\Measurement;

/**
 * This class aims to validate the current measurement
 * temperature to ensure it's in the range.
 * If it doesn't return an error message.
 */
class TemperatureAlertStrategy implements AlertStrategy
{
    /**
     * Check the temperature measurement if between the range.
     * Returns message if not.
     *
     * @param Measurement $measurement
     * @return string[]|null
     */
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
