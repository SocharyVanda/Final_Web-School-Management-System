<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['school_name', 'logo', 'academic_year', 'semester'];
}
