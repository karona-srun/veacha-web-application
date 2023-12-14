<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'key', 'project','user_id','description','status',
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }
}
