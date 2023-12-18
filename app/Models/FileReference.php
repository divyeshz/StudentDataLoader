<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class FileReference extends BaseModel
{
    use HasFactory;

    protected $table = 'file_references';

    // Define the fillable fields
    protected $fillable = ['filename'];
}
