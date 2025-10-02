<?php

namespace App\Http\Controllers;

use App\Http\Requests\Measurements\CreateMeasurementRequest;
use App\Models\Device;
use Illuminate\Http\JsonResponse;

class MeasurementController extends Controller
{
    /**
     * Create a new device measurement
     *
     * @param CreateMeasurementRequest $request
     * @return JsonResponse
     */
    public function store(CreateMeasurementRequest $request): JsonResponse
    {
        $device = Device::findOrFail($request->device);
        $device
            ->measurements()
            ->create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'The new measurement has been created successfully.',
        ]);
    }
}
