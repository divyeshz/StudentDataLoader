<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomSchedule extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'schedule_type',
        'datetime',
        'schedule_value',
        'is_active',
        'is_send',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_send'   => 'boolean',
        'datetime'  => 'datetime',
    ];
}
