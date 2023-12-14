<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends BaseModel
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'roll_no',
        'name',
        'class',
        'email',
        'gender',
        'guardian_name',
        'guardian_email',
        'city',
        'state',
        'pincode',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
