<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\DivisionMember;
use App\Models\Member;
use Illuminate\Database\Seeder;

class DivisionMemberTableSeeder extends Seeder
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
                'division_id'          => Division::all()->random()->id,
            ];
        }
        DivisionMember::insert($division_member);
    }
}
