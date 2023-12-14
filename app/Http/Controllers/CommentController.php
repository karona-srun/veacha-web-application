<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Models\Attachment;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'comment' => 'required',
        ]);

        $input = $request->all();
           
        $comment= new Comment();
        $comment->project_id= $input['project_id'];
        $comment->task_id = $input['task_id'];
        $comment->user_id= $input['user_id'];
        $comment->comment= $input['comment'];
        $comment->status= "0";
        $comment->is_removed= "0";
        $comment->save();

        $name = 'N/A'; $path = 'N/A';
        if($request->hasfile('file'))
         {
            $file = $request->file('file');
            $name=date('YmdHis').'_'.rand() .$file->getClientOriginalName();
            $request->file('file')->storeAs('uploads/comments/', $name);  
         }

        $file= new Attachment();
        $file->type = 'comments';
        $file->attachment_id =$comment->id;
        $file->name=$name;
        $file->path="null";  
        $file->save();

       $notification = array(
            'message' => 'Comment has been created successfully.', 
            'alert-type' => 'success',
        );

        LogActivity::addToLog('Comment',Auth::User()->id,Auth::User()->name,'Create',$input['comment']);

        return redirect()->back()->with($notification); 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $data = DB::table('comments')
        // ->join('files','files.foreign_id','=','comments.id')
        // ->select('comments.comments_id, comments.comment, files.id as file_id, files.file')
        // ->where('comments.id',$id)
        // ->get();
        // return response()->json ($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $data = DB::table('comments')
        // ->join('files','files.foreign_id','comments.id')
        // ->select('comments.id as comments_id, comments.comment, files.id as file_id, files.file')
        // ->where('comments.id',$id)
        // ->get();
        // return response()->json ($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id = null)
    {

        $this->validate($request, [
            'comment' => 'required',
        ]);

        $input = $request->all();
        $comment= Comment::find($id);
        $comment->comment= $input['comment'];
        $comment->save();
        $name = 'N/A'; $path = 'N/A';
        if($request->hasfile('file'))
         {
            $file = $request->file('file');
            $name=date('YmdHis').'_'.rand() .$file->getClientOriginalName();
            //$file->move(storage_path().'/uploads/comments/', $name);
            $request->file('file')->storeAs('uploads/comments/', $name);
            DB::table('attachments')
            ->where('attachment_id', $id)
            ->update(['name'=>$name]);
         }

        

        $notification = array(
            'message' => 'Comment has been updated successfully.', 
            'alert-type' => 'success',
        );
        LogActivity::addToLog('Comment',Auth::User()->id,Auth::User()->name,'Update',$input['comment']);

        return back()->with($notification);

    }

    public function is_removed($id)
    {

        $comment= Comment::find($id);
        // $comment->is_removed= "1";
        $comment->delete();
        LogActivity::addToLog('Comment',Auth::User()->id,Auth::User()->name,'Delete',$id);

        $notification = array(
            'message' => 'Comment has been deleted successfully.', 
            'alert-type' => 'error'
        );

        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function download($name){
        $path = storage_path('app/uploads/comments/').$name;
        if(file_exists($path)){
            return response()->download($path);
        }else{
            return abort(404);
        }
    }
}
