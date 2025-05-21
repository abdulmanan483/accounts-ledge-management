<?php

namespace Database\Seeders;

use App\Enums\Permissions\PermissionType;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissionsByType = [
            PermissionType::ADMIN_PANEL->value => [
                // 'dashboard' => [
                //     'dashboard-participantsCityWiseChart',
                // ],
                'media' => [
                    'media-list', 'media-view', 'media-create', 'media-edit', 'media-delete',
                ],
                'provinces' => [
                    'provinces-list', 'provinces-view', 'provinces-create', 'provinces-edit', 'provinces-delete',
                ],
                'states' => [
                    'states-list', 'states-view', 'states-create', 'states-edit', 'states-delete',
                ],
                'cities' => [
                    'cities-list', 'cities-view', 'cities-create', 'cities-edit', 'cities-delete',
                ],
                'sites' => [
                    'sites-list', 'sites-view', 'sites-create', 'sites-edit', 'sites-delete',
                ],
                'floors' => [
                    'floors-list', 'floors-view', 'floors-create', 'floors-edit', 'floors-delete',
                ],
                'blocks' => [
                    'blocks-list', 'blocks-view', 'blocks-create', 'blocks-edit', 'blocks-delete',
                ],
                'departments' => [
                    'departments-list', 'departments-view', 'departments-create', 'departments-edit', 'departments-delete',
                ],
                'locations' => [
                    'locations-list', 'locations-view', 'locations-create', 'locations-edit', 'locations-delete',
                ],
                'roles' => [
                    'roles-list', 'roles-view', 'roles-create', 'roles-edit', 'roles-delete',
                ],
                'users' => [
                    'users-list', 'users-view', 'users-create', 'users-edit', 'users-delete',
                ],
                'notifications' => [
                    'notifications-list', 'notifications-view', 'notifications-create', 'notifications-edit', 'notifications-delete',
                ],
                'audits' => [
                    'audits-list', 'audits-view', 'audits-create', 'audits-edit', 'audits-delete',
                ],
                'logs' => [
                    'logs-list', 'logs-view', 'logs-create', 'logs-edit', 'logs-delete',
                ],
                'settings' => [
                    'settings-list', 'settings-save',
                ],
            ],

            PermissionType::MOBILE_APP->value => [
                // Example: You can add mobile-specific permissions here
                // 'app-users' => [
                //     'app-users-view',
                //     'app-users-update',
                // ],
                // 'app-settings' => [
                //     'app-settings-update',
                // ],
            ],
        ];

        foreach ($permissionsByType as $type => $groups) {
            foreach ($groups as $group => $perms) {
                foreach ($perms as $permissionName) {
                    // $action = last(explode('-', $permissionName));
                    $action = $permissionName;
                    Permission::updateOrCreate(
                        ['name' => $permissionName],
                        [
                            'display_name'  => Str::title(str_replace('-', ' ', $action)),
                            'group'         => $group,
                            'display_group' => Str::title(str_replace('-', ' ', $group)),
                            'type'          => $type,
                            'display_type'  => PermissionType::tryFrom($type)->label(),
                        ]
                    );
                }
            }
        }
    }
}
