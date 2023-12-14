<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Project;
use App\Models\Comment;
use App\Models\Logwork;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $record = User::select(DB::raw("COUNT(*) as count"), DB::raw("name as name"), DB::raw("DAY(created_at) as day"))
            ->groupBy('name', 'day')
            ->orderBy('day')
            ->get();
        $data = [];

        foreach ($record as $row) {
            $data['label'][] = $row->name;
            $data['data'][] = (int) $row->count;
        }
        $data['chart_data_user'] = json_encode($data);

        $record1 = Project::select(DB::raw("COUNT(*) as count"), DB::raw("project as name"), DB::raw("DAY(created_at) as day"))
            ->groupBy('name', 'day')
            ->orderBy('day')
            ->get();
        $data1 = [];

        foreach ($record1 as $row) {
            $data1['label'][] = $row->name;
            $data1['data'][] = (int) $row->count;
        }
        $data1['chart_data_project'] = json_encode($data1);

        $comment = Comment::whereDate('created_at', '=', Carbon::today()->toDateString())->get();
        $commentCount = $comment->count();

        $logwork = Logwork::whereDate('created_at', '=', Carbon::today()->toDateString())->get();
        $logworkCount = $logwork->count();

        $title = array(
            'title' => 'Dashboard',
            'description' => 'This is New Application',
            'commentCount' => $commentCount,
            'logworkCount' => $logworkCount,
        );

        return view('home', $data, $data1)->with($title);
    }

    public function displayImage($filename)
    {
        $path = storage_path('photos/' . $filename);

        if (!File::exists($path)) {

            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }
    public function yourWork()
    {
        return view('yourwork');
    }
}
