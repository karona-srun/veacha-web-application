<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity as HelpersLogActivity;
use App\Models\Attachment;
use App\Models\Logwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogworkController extends Controller
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
            'time_spent' => 'required',
            'date' => 'required',
            'logwork' => 'required',
        ]);

        $input = $request->all();
           
        $logwork= new Logwork();
        $logwork->user_id= $input['user_id'];
        $logwork->task_id = $input['task_id'];
        $logwork->time_spent = $input['time_spent'];
        $logwork->current_date = $input['date'];
        $logwork->logwork= $input['logwork'];
        $logwork->status= "0";
        $logwork->is_removed= "0";
        $logwork->save();

        $name = null; $path = null;
        if($request->hasFile('file')){
            if ($files = $input['file']) {
                $name=date('YmdHis').'_worklog_'.rand() .'.'.$files->getClientOriginalName();
                //$path = $files->move(public_path('photos'), $name);
                $path = $request->file('file')->storeAs('uploads/logworks/', $name);
            }
        }
        
        $file= new Attachment();
        $file->type = 'logworks';
        $file->attachment_id =$logwork->id;
        $file->name=$name;
        $file->path= $path;  
        $file->save();

        HelpersLogActivity::addToLog('Log work',Auth::User()->id,Auth::User()->name,'Create',$input['logwork']);

       $notification = array(
            'message' => 'Work log has been created successfully.', 
            'alert-type' => 'success',
        );

        return back()->with($notification); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'etime_spent' => 'required',
            'edate' => 'required',
            'elogwork' => 'required',
        ]);
        $input = $request->all();
        
        $logwork= Logwork::find($id);
        $logwork->time_spent = $input['etime_spent'];
        $logwork->current_date = $input['edate'];
        $logwork->logwork= $input['elogwork'];
        $logwork->save();

        $name = null; $path = '';
        if($request->hasFile('file')){
            if ($files = $input['file']) {
                $name=date('YmdHis').'_worklog_'.rand() .'.'.$files->getClientOriginalName();
                //$path = $files->move(public_path('photos'), $name);
                $request->file('file')->storeAs('uploads/logworks/', $name);
            }
            DB::table('attachments')
         ->where('attachment_id', $id)
         ->update(['name'=>$name]);
        }

         


        HelpersLogActivity::addToLog('Log work',Auth::User()->id,Auth::User()->name,'Update',$input['elogwork']);

       $notification = array(
            'message' => 'Work log has been updated successfully.', 
            'alert-type' => 'success',
        );

        return back()->with($notification);
    }

    public function is_removed($id)
    {
        $logwork= Logwork::find($id);
        $logwork->is_removed= "1";
        $logwork->delete();

        HelpersLogActivity::addToLog('Log work',Auth::User()->id,Auth::User()->name,'Delete',$id);

        $notification = array(
            'message' => 'Log work has been deleted successfully.', 
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
        //
    }

    public function download($name){
        $path = storage_path('app/uploads/logworks/').$name;
        if(file_exists($path)){
            return response()->download($path);
        }else{
            return abort(404);
        }
    }
}
