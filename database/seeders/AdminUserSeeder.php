<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
        if (!User::where('email', 'superadmin@gmail.com')->exists()) {
            $user = User::create([
                'name'     => 'Super Admin',
                'email'    => 'superadmin@gmail.com',
                'password' => 'password',
            ]);

            // Check if the role already exists
            $role = Role::firstOrCreate(
                ['name' => 'Super Admin', 'guard_name' => 'web']
            );

            // Assign all permissions to the role
            $role->syncPermissions(Permission::all());

            // Assign role to user
            $user->assignRole($role);
        }
    }
}
