<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class demobackup extends Model
{
    protected $table = 'demobackups';
    protected $fillable = ['name', 'description'];
}
