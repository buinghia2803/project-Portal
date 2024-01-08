<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shift;
use Carbon\Carbon;

class ShiftsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shift = [
            [
                'id'             => 1,
                'shift_name'     => 'Ca 1',
                'check_in'       => '08:30',
                'check_out'      => '17:30',
                'work_time'      => '08:00',
                'lunch_break'    => 60,
                'duration_start' => Carbon::rawCreateFromFormat('Y-m-d', '2022-01-01'),
                'duration_end'   => null
            ],
            [
                'id'             => 2,
                'shift_name'     => 'Ca 2',
                'check_in'       => '08:00',
                'check_out'      => '17:00',
                'work_time'      => '08:00',
                'lunch_break'    => 60,
                'duration_start' => Carbon::rawCreateFromFormat('Y-m-d', '2022-01-01'),
                'duration_end'   => null
            ],
            [
                'id'             => 3,
                'shift_name'     => 'Ca 3',
                'check_in'       => '09:00',
                'check_out'      => '18:00',
                'work_time'      => '08:00',
                'lunch_break'    => 60,
                'duration_start' => Carbon::rawCreateFromFormat('Y-m-d', '2022-01-01'),
                'duration_end'   => null
            ]
        ];

        Shift::insert($shift);
    }
}
