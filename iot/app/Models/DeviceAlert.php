<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeviceAlert extends Model
{
    use HasFactory;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'device_alerts';

    /**
     * Properties
     *
     * @var string[]
     */
    protected $fillable = [
        'type',
        'message',
        'created_at',
        'updated_at',
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
     * Many-to-one relationship with Measurement
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function measurement() {
        return $this->belongsTo(Measurement::class);
    }
}
