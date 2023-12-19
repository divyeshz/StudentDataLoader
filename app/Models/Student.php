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
        'email',
        'gender',
        'guardian_name',
        'guardian_email',
        'city',
        'state',
        'pincode',
        'file_reference_id',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function results() {
        return $this->hasMany(Result::class, 'std_id', 'id');
    }

    public function fileReference()
    {
        return $this->belongsTo(FileReference::class);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
