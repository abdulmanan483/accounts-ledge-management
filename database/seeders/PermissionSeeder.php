<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'dashboard-participantsCityWiseChart',

            'provinces-list',
            'provinces-view',
            'provinces-create',
            'provinces-edit',
            'provinces-delete',

            'states-list',
            'states-view',
            'states-create',
            'states-edit',
            'states-delete',

            'cities-list',
            'cities-view',
            'cities-create',
            'cities-edit',
            'cities-delete',

            'sites-list',
            'sites-view',
            'sites-create',
            'sites-edit',
            'sites-delete',

            'floors-list',
            'floors-view',
            'floors-create',
            'floors-edit',
            'floors-delete',

            'blocks-list',
            'blocks-view',
            'blocks-create',
            'blocks-edit',
            'blocks-delete',

            'departments-list',
            'departments-view',
            'departments-create',
            'departments-edit',
            'departments-delete',

            'roles-list',
            'roles-view',
            'roles-create',
            'roles-edit',
            'roles-delete',

            'users-list',
            'users-view',
            'users-create',
            'users-edit',
            'users-delete',

            'notifications-list',
            'notifications-view',
            'notifications-create',
            'notifications-edit',
            'notifications-delete',

            'audits-list',
            'audits-view',
            'audits-create',
            'audits-edit',
            'audits-delete',

            'logs-list',
            'logs-view',
            'logs-create',
            'logs-edit',
            'logs-delete',

            'settings-list',
            'settings-save',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }
    }
}
