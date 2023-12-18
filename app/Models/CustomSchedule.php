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
}
