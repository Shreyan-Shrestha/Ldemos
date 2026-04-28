<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LDemo extends Model
{
    protected $table = 'l_demos';
    protected $fillable = ['name', 'description'];    
}
