<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
               'name' => 'Karona Srun', 
                'email' => 'admin@gmail.com',
                'phone' => '000000000',
                'status' => '1',
                'role' => '1',
                'description' => 'Full accessible',
                'password' => Hash::make('12345678')
            ]);
        // $user = User::create([
        //         'name' => 'SuperAdmin', 
        //         'email' => 'superadmin@gmail.com',
        //         'phone' => '000000000',
        //         'status' => '1',
        //         'role' => '2',
        //         'description' => 'Limit accessible',
        //         'password' => Hash::make('12345678')
        //     ]);
        // $user = User::create([
        //         'name' => 'User', 
        //         'email' => 'user@gmail.com',
        //         'phone' => '000000000',
        //         'status' => '1',
        //         'role' => '3',
        //         'description' => 'Limit accessible',
        //         'password' => Hash::make('12345678')
        // ]);
  
        $role = Role::create([
                'key' => 'ADM',
                'name' => 'Administrator',
                'description' => 'Full accessible'
            ]);
        // $role = Role::create([
        //         'key' => 'SUADM',
        //         'name' => 'SuperAdmin',
        //         'description' => 'Limit accessible'
        //     ]);
        // $role = Role::create([
        //         'key' => 'USE',
        //         'name' => 'User',
        //         'description' => 'Limit accessible'
        // ]); 

        $permissions = Permission::pluck('id','id')->all();  
        $role->syncPermissions($permissions);   
        $user->assignRole([$role->id]);

    }
}
