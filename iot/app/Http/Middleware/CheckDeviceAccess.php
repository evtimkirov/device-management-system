<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use App\Models\Device;

class CheckDeviceAccess
{
    /**
     * Check if the logged user have access to the device parameters.
     *
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // Check the user ID attached to the device and logged user
        $deviceId = $request->route('device');
        if ($deviceId) {
            $device = Device::find($deviceId);
            if (!$device) {
                return response()->json(
                    [
                        'status'  => 'error',
                        'message' => 'Not found.',
                    ],
                    404
                );
            }

            // If try to attach device to another user
            if ($device->users()->count() === 0 && (int) $request->route('user') !== $user->id) {
                return response()->json(
                    [
                        'status'  => 'error',
                        'message' => 'You don\'t have permissions.',
                    ],
                    403
                );
            }

            // Check if device is assigned to the logged user
            if ($device->users()->count() !== 0 && $device->users()->first()->id !== $user->id) {
                return response()->json(
                    [
                        'status'  => 'error',
                        'message' => 'You don\'t have permissions.',
                    ],
                    403
                );
            }
        } else {
            // Check if you can access the requested user
            $userId = $request->route('user');
            if ($userId) {
                $targetUser = User::find($userId);
                if (!$targetUser) {
                    return response()->json(
                        [
                            'status'  => 'error',
                            'message' => 'User not found.',
                        ],
                        404
                    );
                }

                $targetDevices = $targetUser->devices;

                $commonDevice = $targetDevices->intersect($user->devices)->first();
                if (!$commonDevice) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'You don\'t have permissions.',
                    ],
                        403
                    );
                }
            }
        }

        return $next($request);
    }
}
