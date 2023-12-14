<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Logwork;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class YourworkController extends Controller
{
    
    public function index()
    {
        //$projects = Project::where('user_id', Auth::User()->id)->latest()->paginate(10);
        $projects = DB::table('projects')
                    ->select('*')
                    ->join('project_user','project_user.project_id','=','projects.id')
                    ->where('project_user.user_id', Auth::User()->id)
                    ->paginate(10);
        // $projects = Project::latest()->paginate(10);
        $comment = Comment::where('user_id', '=', Auth::User()->id)->whereDate('created_at','=',Carbon::today()->toDateString())->get();
        $commentCount = $comment->count();

        $logwork = Logwork::where('user_id', '=', Auth::User()->id)->whereDate('created_at','=',Carbon::today()->toDateString())->get();
        $logworkCount = $logwork->count();

        return view('yourwork',compact('projects','commentCount','logworkCount'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

}
