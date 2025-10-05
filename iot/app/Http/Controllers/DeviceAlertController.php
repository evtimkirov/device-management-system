<?php

namespace App\Http\Controllers;

use App\Http\Requests\Alerts\GetAlertsRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class DeviceAlertController extends Controller
{
    /**
     * Returns all the alerts by devices per user
     *
     * @param GetAlertsRequest $request
     * @return JsonResponse
     */
    public function index(GetAlertsRequest $request): JsonResponse
    {
        $user = User::findOrFail($request->user);

        $alerts = $user->devices()
            ->with(['alerts' => function ($query) {
                $query->orderBy('id', 'desc');
            }])
            ->get()
            ->map(function ($device) {
                return [
                    'device_name' => $device->name,
                    'alerts'      => $device->alerts->map(function ($alert) use ($device) {
                        return [
                            'type'        => $alert->type,
                            'message'     => $alert->message,
                            'created_at'  => $alert->created_at->format('Y-m-d H:i:s'),
                        ];
                    }),
                ];
            });

        return response()->json(
            [
                'status'  => 'success',
                'message' => 'Alerts list.',
                'data'    => $alerts,
            ]
        );
    }
}
