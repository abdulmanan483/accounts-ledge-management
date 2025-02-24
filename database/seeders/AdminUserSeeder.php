<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if the user already exists
        $user = User::where('email', 'superadmin@gmail.com')->first();
        if (! $user) {
            $user = User::create([
                'name'     => 'Super Admin',
                'email'    => 'superadmin@gmail.com',
                'password' => 'password',
            ]);

        }
        // Check if the role already exists
        $role = Role::where('name', 'Super Admin')->first();
        if (!$role) {
            $role = Role::create([
                'name' => 'Super Admin',
                'guard_name' => 'web',
            ]);
        }


        // Assign all permissions to the role
        $role->syncPermissions(Permission::all());

        // Assign role to user if not already assigned
        if (!$user->hasRole($role->name)) {
            $user->assignRole($role);
        }
    }
}
