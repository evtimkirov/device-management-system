<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use App\Models\Device;

class CheckDeviceAccess
{
    /**
     * Handle incoming request and check device access.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed|true
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($deviceId = $request->route('device')) {
            $response = $this->checkDeviceAccess($deviceId, $user, $request);
        } else {
            $response = $this->checkUserAccess($request->route('user'), $user);
        }

        if ($response !== true) {
            return $response;
        }

        return $next($request);
    }

    /**
     * Check if logged user has access to a specific device.
     *
     * @param int $deviceId
     * @param User $user
     * @param Request $request
     * @return mixed|true
     */
    protected function checkDeviceAccess(int $deviceId, User $user, Request $request)
    {
        $device = Device::find($deviceId);

        if (!$device) {
            return $this->errorResponse('Not found.', 404);
        }

        // If trying to attach a device to another user
        if ($device->users()->count() === 0 && (int) $request->route('user') !== $user->id) {
            return $this->errorResponse('You don\'t have permissions.');
        }

        // If device is already assigned but not to the logged user
        if ($device->users()->count() !== 0 && $device->users()->first()->id !== $user->id) {
            return $this->errorResponse('You don\'t have permissions.');
        }

        return true;
    }

    /**
     * Check if logged user has access to another user's devices.
     *
     * @param int|null $userId
     * @param User $user
     * @return mixed|true
     */
    protected function checkUserAccess(?int $userId, User $user)
    {
        if (!$userId) {
            return true; // няма user параметър – няма какво да проверяваме
        }

        $targetUser = User::find($userId);
        if (!$targetUser) {
            return $this->errorResponse('User not found.', 404);
        }

        $commonDevice = $targetUser->devices->intersect($user->devices)->first();
        if (!$commonDevice) {
            return $this->errorResponse('You don\'t have permissions.');
        }

        return true;
    }

    /**
     * Standard error response.
     *
     * @param string $message
     * @param int $status
     * @return mixed
     */
    protected function errorResponse(string $message, int $status = 403)
    {
        return response()->json([
            'status'  => 'error',
            'message' => $message,
        ], $status);
    }
}
