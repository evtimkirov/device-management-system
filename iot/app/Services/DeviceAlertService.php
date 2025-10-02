<?php

namespace App\Services;

use App\Models\DeviceAlert;
use App\Models\Measurement;

class DeviceAlertService
{
    /**
     * Check measurement and create alert if needed.
     *
     * @param Measurement $measurement
     * @return DeviceAlert|null
     */
    public function checkAndCreateAlert(Measurement $measurement): ?DeviceAlert
    {
        if ($measurement->temperature < 0 || $measurement->temperature > 30) {
            return DeviceAlert::create([
                'device_id'      => $measurement->device_id,
                'measurement_id' => $measurement->id,
                'type'           => 'temperature_threshold',
                'message'        => "Temperature {$measurement->temperature}°C is out of safe range (0–30).",
            ]);
        }

        return null;
    }
}
