<?php

namespace App\Listeners;

use App\Events\MeasurementCreated;
use App\Models\DeviceAlert;

class CheckTemperatureAlert
{
    /**
     * Handle the event.
     */
    public function handle(MeasurementCreated $event): void
    {
        $measurement = $event->measurement;

        if ($measurement->temperature < 0 || $measurement->temperature > 30) {
            DeviceAlert::create([
                'device_id'      => $measurement->device_id,
                'measurement_id' => $measurement->id,
                'type'           => 'temperature_threshold',
                'message'        => "Temperature {$measurement->temperature}°C is out of safe range (0–30).",
            ]);
        }
    }
}
