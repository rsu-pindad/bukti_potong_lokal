<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions pajak
        Permission::create(['name' => 'view bukti_potong']);
        Permission::create(['name' => 'edit bukti_potong']);
        Permission::create(['name' => 'create bukti_potong']);
        Permission::create(['name' => 'delete bukti_potong']);
        Permission::create(['name' => 'publish bukti_potong']);
        Permission::create(['name' => 'upload bukti_potong']);

        Permission::create(['name' => 'view personalia']);
        Permission::create(['name' => 'edit personalia']);
        Permission::create(['name' => 'create personalia']);
        Permission::create(['name' => 'delete personalia']);
        Permission::create(['name' => 'publish personalia']);
        Permission::create(['name' => 'upload personalia']);
        // Permission::create(['name' => 'pdf payroll_kehadiran']);

        User::flushEventListeners();
        // create roles and assign created permissions
        // $pass = config('app.seeder_default');
        $pass = 12345;

        $role1 = Role::create(['name' => 'pajak']);
        $role1->givePermissionTo(['view bukti_potong', 'edit bukti_potong', 'create bukti_potong', 'delete bukti_potong', 'publish bukti_potong']);

        $role2 = Role::create(['name' => 'personalia']);
        $role2->givePermissionTo(['view personalia', 'edit personalia', 'create personalia', 'delete personalia', 'publish personalia', 'upload personalia']);

        $role4 = Role::create(['name' => 'super-admin']);
        $role5 = Role::create(['name' => 'employee']);
        $role5->givePermissionTo(['view bukti_potong']);

        $role4->givePermissionTo(Permission::all());
        $user4 = User::create([
            'username'       => 'it',
            'password'       => Hash::make($pass),
        ]);
        $user4->assignRole($role4);

        $user1 = User::create([
            'username'       => 'pajak',
            'password'       => Hash::make($pass), 
        ]);
        $user1->assignRole($role1);

        $user2 = User::create([
            'username'       => 'personalia',
            'password'       => Hash::make($pass),
        ]);
        $user2->assignRole($role2);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
