<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    public $incrementing = false;
    public static function boot()
    {
        parent::boot();

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
