<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomSchedule extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'schedule_type',
        'datetime',
        'std_roll_no',
        'class',
        'is_active',
        'status',
        'created_by',
        'updated_by',
    ];
}
