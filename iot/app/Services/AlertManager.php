<?php

namespace App\Services;

use App\Models\DeviceAlert;
use App\Models\Measurement;

/**
 * The class creates a new alert with the proper parameters depending on the specific measurements.
 */
class AlertManager
{
    /**
     * Constructor accept an array with different strategies
     *
     * @param array $strategies
     */
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
