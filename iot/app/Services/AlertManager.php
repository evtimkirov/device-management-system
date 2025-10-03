<?php

namespace App\Services;

use App\Models\DeviceAlert;
use App\Models\Measurement;

class AlertManager
{
    public function __construct(protected array $strategies) {}

    /**
     * Creates a new device alert by the selected types
     *
     * @param Measurement $measurement
     * @return array
     */
    public function checkAndCreateAlerts(Measurement $measurement): array
    {
        $alerts = [];
        foreach ($this->strategies as $strategy) {
            $result = $strategy->check($measurement);

            if ($result) {
                $alerts[] = DeviceAlert::create(array_merge($result, [
                    'device_id'      => $measurement->device_id,
                    'measurement_id' => $measurement->id,
                ]));
            }
        }

        return $alerts;
    }
}
