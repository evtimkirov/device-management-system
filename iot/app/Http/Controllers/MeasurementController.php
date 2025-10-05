<?php

namespace App\Http\Controllers;

use App\Events\MeasurementCreated;
use App\Http\Requests\Measurements\CreateMeasurementRequest;
use App\Http\Requests\Measurements\GetMeasurementsRequest;
use App\Models\Device;
use App\Models\Measurement;
use App\Services\AlertManager;
use Illuminate\Http\JsonResponse;

class MeasurementController extends Controller
{
    /**
     * Returns the measurements with devices per user
     *
     * @param GetMeasurementsRequest $request
     * @return JsonResponse
     */
    public function index(GetMeasurementsRequest $request): JsonResponse
    {
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Measurements list.',
                'data' => Measurement::getMeasurementsByDevices($request->user),
            ]
        );
    }

    /**
     * Create a new device measurement
     *
     * @param CreateMeasurementRequest $request
     * @return JsonResponse
     */
    public function store(CreateMeasurementRequest $request): JsonResponse
    {
        $device      = Device::findOrFail($request->device);
        $measurement = $device
            ->measurements()
            ->create($request->validated());

        MeasurementCreated::dispatch($measurement);

        return response()->json([
            'status' => 'success',
            'message' => 'The new measurement has been created successfully.',
        ]);
    }
}
