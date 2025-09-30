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
}
