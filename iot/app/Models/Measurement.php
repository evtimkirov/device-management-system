<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Measurement extends Model
{
    use HasFactory;

    /**
     * Ignore the created_at and updated_at columns
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'measurements';

    /**
     * Properties
     *
     * @var string[]
     */
    protected $fillable = [
        'temperature',
        'measured_at',
    ];

    /**
     * Many-to-one relationship with Device
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device() {
        return $this->belongsTo(Device::class);
    }

    /**
     * Gets measurements by devices per user
     *
     * @param $userId
     * @return mixed
     */
    public static function getMeasurementsByDevices($userId): mixed
    {
        $user = User::findOrFail($userId);

        return $user->devices()
            ->with(['measurements' => function ($query) {
                $query->orderBy('id', 'desc');
            }])
            ->get()
            ->map(function ($device) {
                return [
                    'device_name' => $device->name,
                    'measurements' => $device->measurements->map(function ($measurement) {
                        return [
                            'temperature' => $measurement->temperature,
                            'measured_at' => $measurement->measured_at,
                        ];
                    }),
                ];
            });
    }
}
