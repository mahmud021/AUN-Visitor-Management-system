<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $fillable = [
        'visitor_start_time',
        'visitor_end_time',
    ];
}
