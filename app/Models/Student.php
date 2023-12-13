<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Student extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;

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
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected static function booted()
    {
        static::creating(function ($module) {
            $module->id = Str::uuid()->toString();
            $userId = auth()->id() ?? null;
            $module->created_by = $userId;
        });

        static::updating(function ($module) {
            $userId = auth()->id() ?? null;
            $module->updated_by = $userId;
        });

        static::deleting(function ($module) {
            $userId = auth()->id() ?? null;
            $module->deleted_by = $userId;
        });
    }
}
