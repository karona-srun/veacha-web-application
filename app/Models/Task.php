<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    protected $fillable = [
        'name', 'description'
    ];
    
    public function files()
    {
        return $this->belongsToMany('App\Models\File');
    }

    public function creator()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function getFileDownload($id)
    {
        $file = DB::table('tasks')
        ->join('attachments','tasks.id','=','attachments.attachment_id')
        ->select('attachments.name')
        ->where('tasks.id','=',$id)
        ->where('attachments.type','tasks')
        ->get();
        return $file;
    }

}
