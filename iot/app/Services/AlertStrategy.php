<?php

namespace App\Services;

use App\Models\Measurement;

interface AlertStrategy
{
    public function check(Measurement $measurement): ?array;
}
