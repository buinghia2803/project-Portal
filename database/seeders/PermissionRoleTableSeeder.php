<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));

        $user_permissions = $admin_permissions->filter(function ($permission) {
            return substr($permission->title, 0, 5) != 'user_' && substr($permission->title, 0, 5) != 'role_' && substr($permission->title, 0, 11) != 'permission_';
        });
        Role::findOrFail(2)->permissions()->sync($user_permissions);

        $member_permissions = $admin_permissions->filter(function ($permission) {
            return substr($permission->title, 0, 5) != 'user_' && substr($permission->title, 0, 5) != 'role_' && substr($permission->title, 0, 11) != 'permission_'
                && substr($permission->title, 0, 8) != 'manager_' && substr($permission->title, 0, 9) != 'division_' && substr($permission->title, 0, 13) != 'notification_'
                && substr($permission->title, 0, 13) != 'point_action_' && substr($permission->title, 0, 8) != 'holiday_' && substr($permission->title, 0, 6) != 'leave_'
                && substr($permission->title, 0, 16) != 'request_manager_' && substr($permission->title, 0, 8) != 'request_' && substr($permission->title, 0, 5) != 'team_'
                && substr($permission->title, 0, 17) != 'profile_password_';
        });
        Role::findOrFail(3)->permissions()->sync($member_permissions);
    }
}
