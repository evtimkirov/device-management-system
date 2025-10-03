<?php

namespace App\Http\Controllers;

use App\Http\Requests\Devices\AttachOrDetachDeviceRequest;
use App\Http\Requests\Devices\CreateDeviceRequest;
use App\Http\Requests\Devices\DeleteDeviceRequest;
use App\Models\Device;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class DeviceController extends Controller
{
    /**
     * Create a new device
     *
     * @param CreateDeviceRequest $request
     * @return JsonResponse
     */
    public function store(CreateDeviceRequest $request): JsonResponse
    {
        $device = Device::create($request->only(['name', 'serial_number']));

        return response()->json([
            'status'    => 'success',
            'message'   => 'The device has been created successfully.',
            'data'      => $device,
        ]);
    }

    /**
     * Delete a device
     *
     * @param DeleteDeviceRequest $request
     * @return JsonResponse
     */
    public function destroy(DeleteDeviceRequest $request): JsonResponse
    {
        Device::findOrFail($request->id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'The device has been deleted successfully.',
        ]);
    }

    /**
     * Attach device to a user
     *
     * @param AttachOrDetachDeviceRequest $request
     * @return JsonResponse
     */
    public function attachDevice(AttachOrDetachDeviceRequest $request): JsonResponse
    {
        $user = User::findOrFail($request->user_id);
        $user->devices()->syncWithoutDetaching([$request->device_id]);

        return response()->json([
            'status' => 'success',
            'message' => 'The device has been attached successfully.',
        ]);
    }

    /**
     * Detach device
     *
     * @param AttachOrDetachDeviceRequest $request
     * @return JsonResponse
     */
    public function detachDevice(AttachOrDetachDeviceRequest $request): JsonResponse
    {
        $user = User::findOrFail($request->user_id);
        $user->devices()->detach($request->device_id);

        return response()->json([
            'status' => 'success',
            'message' => 'The device has been detached successfully.',
        ]);
    }
}
