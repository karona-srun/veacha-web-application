<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    // function __construct()

    // {

    //      $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);

    //      $this->middleware('permission:role-create', ['only' => ['create','store']]);

    //      $this->middleware('permission:role-edit', ['only' => ['edit','update']]);

    //      $this->middleware('permission:role-delete', ['only' => ['destroy']]);

    // }



    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)

    {
        $roles = Role::orderBy('id','DESC')->paginate(5);
        $data1 = array(
            'title'=>'Roles',
            'description'=>'This is New Application',
            'author'=>'foo'
            );
        return view('roles.index',compact('roles'))->with($data1);

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()
    {
        $permission = Permission::get();
        $data1 = array(
            'title'=>'Roles',
            'description'=>'This is New Application',
            'author'=>'foo'
            );
        return view('roles.create',compact('permission'))->with($data1);
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
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
        $role = Role::create(
            ['key' => $request->input('key'),
            'name' =>$request->input('name'),
            'description' =>$request->input('description')]);
        $role->syncPermissions($request->input('permission'));
        return redirect()->route('roles.index')
                        ->with('success','Role created successfully');

    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        $role = Role::find($id);

        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")

            ->where("role_has_permissions.role_id",$id)

            ->get();

            $data1 = array(
            'title'=>'Role Management',
            'description'=>'This is New Application',
            'author'=>'foo'
            );

        return view('roles.show',compact('role','rolePermissions'))->with($data1);

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $role = Role::find($id);

        $permission = Permission::get();

        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)

            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')

            ->all();

        $data1 = array(
            'title'=>'Roles',
            'description'=>'This is New Application',
            'author'=>'foo'
            );

        return view('roles.edit',compact('role','permission','rolePermissions'))->with($data1);

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
            'permission' => 'required',
        ]); 
        $role = Role::find($id);
        $role->key = $request->input('key');
        $role->name = $request->input('name');
        $role->description = $request->input('description');
        $role->save();
        $role->syncPermissions($request->input('permission'));
        return redirect()->route('roles.index')
                        ->with('success','Role updated successfully');

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
                        ->with('success','Role deleted successfully');

    }

}