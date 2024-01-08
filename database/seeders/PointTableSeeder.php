<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Point;
use Illuminate\Database\Seeder;

class PointTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $point = [];
        $member_id_count = Member::all()->count();
        for ($member_id = 1; $member_id <= $member_id_count; $member_id++) {
            $point[] = [
                'member_id'          => $member_id,
                'current_point'      => 1000,
                'month_point'        => 1000,
                'total_received'     => 0,
                'total_spent'        => 0,
            ];
        }
        Point::insert($point);
    }
}
