<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {        
        $data = User::orderBy('id','DESC')->paginate(5);
        $data1 = array(
            'title'=>'Users',
            'description'=>'This is New Application',
            'author'=>'foo'
            );
        return view('users.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 5)->with($data1);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $data1 = array(
            'title'=>'Users',
            'description'=>'This is New Application',
            'author'=>'foo'
            );
        return view('users.create',compact('roles'))->with($data1);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response1
     */
    public function store(Request $request)
    {        
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'description' => 'required'
        ]);

        $input = $request->all();
        if($request->hasFile('file')){
            if ($files = $input['photo']) {
                $image = $request->file('photo');
                $new_name = date('YmdHis').'_'.rand() .'_user_'. '.' . $image->getClientOriginalExtension();
                $image->move(public_path('photos'), $new_name);
            } 
        } $new_name = "null"; 

        $password = Hash::make($input['password']);
        $user= new User();
            $user->name= $input['name'];
            $user->email= $input['email'];
            $user->password= $password;
            $user->phone= $input['phone'];
            $user->photo= $new_name;
            $user->status= "1";
            $user->description=  $input['description'];
        $user->save();

        //$user = User::create($input);
        $user->assignRole($request->input('roles'));
        $notification = array(
            'message' => 'User has been created successfully.', 
            'alert-type' => 'success',
        );
        
        return redirect()->route('users.index')->with($notification);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $data1 = array(
            'title'=>'Users',
            'description'=>'This is New Application',
            'author'=>'foo'
            );
        return view('users.show',compact('user'))->with($data1);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        $data1 = array(
            'title'=>'Users',
            'description'=>'This is New Application',
            'author'=>'foo'
            );

        return view('users.edit',compact('user','roles','userRole'))->with($data1);
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'roles' => 'required',
            'description' => 'required'
        ]);

        $input = $request->all();
        //      
        if($request->hasFile('photo')){
        $image = $request->file('photo');
            if($image != '')
            {
                $image_name = date('YmdHis').'_user_'.rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('photos'), $image_name);
            }
        }else $image_name = "null";
        // $password = Hash::make($input['password']);

        // if(!empty($input['password'])){ 
        //     $input['password'] = Hash::make($input['password']);
        // }else{
        //     $input = array_except($input,array('password'));    
        // }


        $user = User::find($id);
            $user->name= $input['name'];
            $user->email= $input['email'];
            $user->phone= $input['phone'];
            $user->photo= $image_name;
            $user->status= "1";
            $user->description=  $input['description'];
        $user->save();

        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        $notification = array(
            'message' => 'User has been updated successfully.', 
            'alert-type' => 'success',
        );
        return redirect()->route('users.index')->with($notification);
    }

    public function editUser($id)
    {
        $user = User::find($id);
        return view('users.edit_user',compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $input = $request->all();
        $user = User::find($id);
            $user->name= $input['name'];
            $user->email= $input['email'];
            $user->phone= $input['phone'];
        $user->save();
        $notification = array(
            'message' => 'User has been updated successfully.', 
            'alert-type' => 'success',
        );
        return back()->with($notification);
    }

    public function changePassword($id)
    {
        $user = User::find($id);
        return view('users.change_password',compact('user'));
    }

    public function updatePassword(Request $request, $id)
    {
        $this->validate($request, [
            'password'     => 'required|min:8',
            'password' => 'required|same:confirm-password'
        ]);

        $user = User::find($id);
        $user->password= Hash::make($request->password);
        $user->save();

        $notification = array(
            'message' => 'User has been changed password successfully.', 
            'alert-type' => 'success',
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
        User::find($id)->delete();
        $notification = array(
            'message' => 'User has been deleted successfully.', 
            'alert-type' => 'success',
        );
        return redirect()->route('users.index')->with($notification);
    }

    public function userBlock($id)
    {
        $user = User::find($id);
        if($user->status == 0){
            $user->status= 1;
            $message = 'User has been unblock successfully.';
        }else{ 
            $user->status= 0;
            $message = 'User has been block successfully.';
        }
        $user->save();
        $notification = array(
            'message' => $message,
            'alert-type' => 'success',
        );
        return redirect()->route('users.index')->with($notification);
    }

    // public function displayImage($filename)
    // {
    //     $path = storage_public('photos/' . $filename);
    
    //     if (!File::exists($path)) {
    //         abort(404);
    //     }
    //     $file = File::get($path);
    //     $type = File::mimeType($path);  

    //     $response = Response::make($file, 200);
    //     $response->header("Content-Type", $type);

    //     return $response;
    // }
}