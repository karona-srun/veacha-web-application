<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    // public function __construct()
    // {
    //      $this->middleware('permission:project-list|project-create|project-edit|project-delete', ['only' => ['index','show']]);
    //      $this->middleware('permission:project-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:project-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:project-delete', ['only' => ['destroy']]);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
            $projects = DB::table('projects')
                    ->select('*')
                    ->join('project_user','project_user.project_id','=','projects.id')
                    ->where('project_user.user_id', Auth::User()->id)
                    ->paginate(10);
        return view('projects.index',compact('projects'))
                    ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::select('id', 'name')->get();
        return view('projects.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required',
            'project' => 'required',
            'user_id' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $input = $request->all();
        $project= new Project();
            $project->key= $input['key'];
            $project->project= $input['project'];
            $project->user_id= $input['uid'];
            $project->description= $input['description'];
            $project->status= "0";
            $project->created_by = $input['created_by'];
        $project->save();
        
        $project->users()->sync($input['user_id']);

        $notification = array(
            'message' => 'Project has been created successfully.', 
            'title' => 'Message',
            'alert-type' => 'success',
            'alert' => 'toast-primary'
        );

        LogActivity::addToLog('Project: '.$input['project'],Auth::User()->id,Auth::User()->name,'Create',$input['description']);

        return redirect()->route('projects.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */

    public function show(Project $project)
    {
        $project = Project::find($project['id']);

        $tasks = DB::table('tasks')
        ->select('*')
        ->where('project_id',$project['id'])
        ->get();
        
        $users = $project->users()
			->orderBy('name', 'asc')
			->get();

        return view('projects.show',compact('users','project','tasks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $userall = User::select('id', 'name')->get();
        $project = Project::find($project['id']);
        $users = $project->users()
			->orderBy('name', 'asc')
			->get();

        return view('projects.edit',compact('users','project','userall'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    
    public function update(Request $request, Project $project)
    {
        request()->validate([
            'key' => 'required',
            'project' => 'required',
            'user_id' => 'required',
            'description' => 'required',
        ]);
        $input = $request->all();
        $project= Project::find($project['id']);
            $project->key= $input['key'];
            $project->project= $input['project'];
            $project->user_id= $input['uid'];
            $project->description= $input['description'];
            $project->created_by = $input['created_by'];
        $project->save();        

        $project->users()->sync($input['user_id']);
        $notification = array(
            'message' => 'Project has been updated successfully.', 
            'alert-type' => 'success',
        );
        LogActivity::addToLog('Project: '.$input['project'],Auth::User()->id,Auth::User()->name,'Update',$input['description']);

        return redirect()->route('projects.index')->with($notification);
    }

    public function changeStatus($id,$pid)
    {
        $project= Project::find($pid);
            $project->status= $id;
        $project->save();  

        LogActivity::addToLog('Project: '.$project->project,Auth::User()->id,Auth::User()->name,'Update','Status: '.$id);

        $notification = array(
            'message' => 'You have been changed status successfully.', 
            'alert-type' => 'success',
        );
        return back()->with($notification);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
//         $brand = Brand::find(1);
// $brand->products()->delete();
    }

    public function excel()
	{
        $formal_data = DB::table('projects')
            ->join('users','users.id','=','projects.user_id')
            ->select('projects.key','projects.project','users.name as member','projects.description',
            'projects.status','projects.created_by','projects.created_at')
            ->get()->toArray();
        //dd($formal_data);
		$programma_array[] = array('key', 'project', 'member', 'description', 'status',
		'created_by', 'created_at');
			
		foreach($formal_data as $pass)
		{
			$programma_array[] = array
			(
			'key'  => $pass->key,
			'project'   => $pass->project,
			'member'    => $pass->member,
				
      		);
			
		}
		
			
			// Excel::create('Programma_Data', function($excel) use ($programma_array)
			// {
			// 	$excel->setTitle('Apotelesmata');
			// 	$excel->sheet('Programma_Data', function($sheet) use ($programma_array)
			// 	{
			// 		$sheet->fromArray($programma_array, null, 'A4', false, false);
			// 	});
			// }) -> download('xlsx');
    }
}
