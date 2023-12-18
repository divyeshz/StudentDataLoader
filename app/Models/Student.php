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
        'import_filename',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function result(){
        return $this->hasOne(Result::class,'std_id');
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
