<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectUser extends Model
{
    protected $table = 'project_user';

    protected $fillable = [
        'user_id','project_id',
    ];

    public function users()
    {
        return $this->morphedByMany(User::class, 'id');
    }

    public function projects()
    {
        return $this->morphedByMany(Project::class, 'id');
    }
}
