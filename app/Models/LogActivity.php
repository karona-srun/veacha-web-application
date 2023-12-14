<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    protected $fillable = [
        'log_name', 'user_id', 'user_name', 'activity_type', 'description'
    ];
}
