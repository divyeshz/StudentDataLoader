<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Result extends BaseModel
{
    use HasFactory;

    protected $table = 'results';

    protected $fillable = [
        'std_id',
        'class',
        'maths',
        'science',
        'hindi',
        'english',
        'social_science',
        'computer',
        'arts',
        'total',
        'percentage',
        'status',
        'created_by',
        'updated_by',
    ];
}
