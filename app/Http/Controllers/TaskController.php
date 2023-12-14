<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\Attachment;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $project = Project::find($request['id']);

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    public function createTicket($id)
    {   
        return view('tasks.create',compact('id'));
    }
    /**
     * Store a newly creat0;ed resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'ticket' => 'required',
            'version' => 'required',
            'description' => 'required',
        ]);

        $input = $request->all();

        $ticket= new Task();
            $ticket->task= $input['ticket'];
            $ticket->project_id= $input['project_id'];
            $ticket->user_id= $input['user_id'];
            $ticket->description= $input['description'];
            $ticket->estimate= $input['estimate'];
            $ticket->version= $input['version'];
            $ticket->status= "0";
            $ticket->created_by = $input['created_by'];
        $ticket->save();

        $data[] = "";
       
        if($request->hasfile('file'))
         {
            foreach($request->file('file') as $file)
            {
                $name=date('YmdHis').'_'.rand() . '.' .$file->getClientOriginalName();
                //$file->move(storage_path().'/uploads/files/', $name);    
                $file->storeAs('uploads/tasks/', $name);
                //$data[] = $name;
                $attachment= new Attachment();
                $attachment->type = 'tasks';
                $attachment->attachment_id =$ticket->id;
                $attachment->name=$name;
                $attachment->path= 'N/A';  
                $attachment->save();
            }
        }
        
        
        LogActivity::addToLog('Task',Auth::User()->id,Auth::User()->name,'Create', $input['ticket'].': '.$input['description']);

        $notification = array(
            'message' => 'Task has been created successfully.', 
            'title' => 'Message',
            'alert-type' => 'success',
            'alert' => 'toast-primary'
        );

        return redirect()->back()->with($notification); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $tickets = Task::find($id);

        $comments = DB::table('comments')
            ->join('users','comments.user_id','=','users.id')
            ->join('attachments','comments.id','=','attachments.attachment_id')
            ->join('tasks','comments.task_id','=','tasks.id')
            ->select('*','comments.user_id as user_id','users.name as name','comments.id as comment_id','attachments.id as file_id','attachments.name as comment_image','attachments.type')
            ->where('comments.task_id','=',$id)
            ->where('attachments.type','comments')
            ->where('comments.is_removed','=',0)
            ->get();

        $logworks = DB::table('logworks')
            ->join('users','users.id','=','logworks.user_id')
            ->join('attachments','attachments.attachment_id','=','logworks.id')
            ->join('tasks','logworks.task_id','=','tasks.id')
            ->select('*','users.name as username','logworks.id as logwork_id','attachments.id as file_id','attachments.name as logwork_image','attachments.type')          
            ->where('logworks.task_id','=',$id)
            ->where('attachments.type','logworks')
            ->where('logworks.is_removed','=',0)
            ->get();
        
        $tracking_time = DB::table("logworks")
            ->leftjoin('tasks','tasks.id','=','logworks.id')
            ->select(DB::raw("SUM(logworks.time_spent) as tracking_time"))
            ->where('logworks.task_id',$id)
            ->first()->tracking_time;
            
        $estimate_time = DB::table("tasks")
            ->select(DB::raw("SUM(estimate) as estimate_time"))
            ->where('id',$id)
            ->first()->estimate_time;
               
        $remaining_time = $estimate_time - $tracking_time;

        $data = array(
            "tracking_time" => $tracking_time,
            "estimate_time" => $estimate_time,
            "remaining_time" => $remaining_time
        );

        $notification = array(
            'message' => 'Task has been created successfully.', 
            'alert-type' => 'success',
        );
        return view('tasks.show',compact('tickets','comments','logworks','data'))->with($notification);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        return view('tasks.edit',compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'ticket' => 'required',
            'version' => 'required',
            'description' => 'required',
        ]);

        $input = $request->all();
        
        $ticket= Task::find($id);
            $ticket->task= $input['ticket'];
            $ticket->estimate= $input['estimate'];
            $ticket->description= $input['description'];
            $ticket->version= $input['version'];
        $ticket->save();

        $tickets = Task::find($id);

        // if($request->hasfile('filename'))
        //  {
        //     // foreach($request->file('filename') as $file)
        //     // {
        //         $file = $request->file('filename');
        //         $name=date('YmdHis').'_'.rand() . '.' .$file->getClientOriginalName();
        //         //$file->move(storage_path().'/uploads/files/', $name);   
        //         $request->file('filename')->storeAs('uploads/files/', $name);
        //     //}
        //     $file= Attachment::where('attachment_id',$id)->update('name',$name);
        //     $file->save();
        //  }

        $data[] = "";
        if($request->hasfile('file'))
         {
            Attachment::where('attachment_id',$id)->delete();
            foreach($request->file('file') as $file)
            {
                $name=date('YmdHis').'_'.rand() . '.' .$file->getClientOriginalName();
                //$file->move(storage_path().'/uploads/files/', $name);    
                $file->storeAs('uploads/tasks/', $name);
                $attachment= new Attachment();
                $attachment->type = 'tasks';
                $attachment->attachment_id =$ticket->id;
                $attachment->name=$name;
                $attachment->path= 'N/A';  
                $attachment->save();
            }
            
        }

        $comments = DB::table('comments')
            ->join('users','comments.user_id','=','users.id')
            ->join('attachments','comments.id','=','attachments.attachment_id')
            ->join('tasks','comments.task_id','=','tasks.id')
            ->select('*','comments.user_id as user_id','users.name as name','comments.id as comment_id','attachments.id as file_id','attachments.name as comment_image')
            ->where('comments.task_id','=',$id)
            ->where('attachments.type','comment')
            ->where('comments.is_removed','=',0)
            ->get();

        $logworks = DB::table('logworks')
            ->join('users','users.id','=','logworks.user_id')
            ->join('attachments','attachments.attachment_id','=','logworks.id')
            ->join('tasks','logworks.task_id','=','tasks.id')
            ->select('*','logworks.id as logwork_id','attachments.id as file_id','attachments.name as logwork_image')          
            ->where('logworks.task_id','=',$id)
            ->where('attachments.type','logwork')
            ->where('logworks.is_removed','=',0)
            ->get();

        LogActivity::addToLog('Task',Auth::User()->id,Auth::User()->name,'Update', $input['ticket'].': '.$input['description']);

        $notification = array(
            'message' => 'Task has been updated successfully.', 
            'alert-type' => 'success',
        );
        
        return view('tasks.show',compact('tickets','comments','logworks'))->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy($ticket)
    {
        //
    }

    public function download($name){
        $path = storage_path('app/uploads/tasks/').$name;
        if(file_exists($path)){
            return response()->download($path);
        }else{
            return abort(404);
        }
    }
}
