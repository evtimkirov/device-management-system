<?php

namespace App\Services;

use App\Models\Measurement;

/**
 * This is an interface
 */
interface AlertStrategy
{
    /**
     * Required method with measurement parameter
     *
     * @param Measurement $measurement
     * @return array|null
     */
    public function check(Measurement $measurement): ?array;
}
