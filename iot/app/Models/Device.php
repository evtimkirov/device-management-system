<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Device extends Model
{
    use HasFactory;

    /**
     * Ignore the created_at and updated_at columns
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Properties
     *
     * @var string[]
     */
    protected $fillable = [
        'serial_number',
        'name',
    ];

    /**
     * Many-to-one relationship with User
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'device_user')
            ->withTimestamps();
    }

    /**
     * One-to-many relationship with Measurement
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function measurements() {
        return $this->hasMany(Measurement::class);
    }

    /**
     * One-to-many relationship with Alert
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alerts() {
        return $this->hasMany(DeviceAlert::class);
    }
}
