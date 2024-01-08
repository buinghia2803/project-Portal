<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $division_member = [];
        $member_id_count = Member::all()->count();
        for ($member_id = 1; $member_id <= $member_id_count; $member_id++) {
            $division_member[] = [
                'member_id'          => $member_id,
                'team_id'          => Team::all()->random()->id,
            ];
        }
        TeamMember::insert($division_member);
    }
}
