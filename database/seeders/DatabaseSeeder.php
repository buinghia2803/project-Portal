<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            NotificationTableSeeder::class,
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            MembersTableSeeder::class,
            RoleMemberTableSeeder::class,
            ShiftsTableSeeder::class,
            DivisionTableSeeder::class,
            TeamsTableSeeder::class,
            PointTableSeeder::class,
            PointActionTableSeeder::class,
            TeamMemberTableSeeder::class,
            DivisionMemberTableSeeder::class,
            // CheckLogTableSeeder::class,
            HolidayTableSeeder::class,
            MemberShiftTableSeeder::class,
            LeaveQuotasTableSeeder::class,
            LeaveRequestsTableSeeder::class,
            WorkSheetTableSeeder::class,
            // RequestsTableSeeder::class,
        ]);
    }
}
