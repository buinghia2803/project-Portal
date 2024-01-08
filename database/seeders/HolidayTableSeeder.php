<?php

namespace Database\Seeders;

use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class HolidayTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $holiday = [
            [
                'title'      => 'Nghỉ 20/11',
                'note'       => 'Abcxyz',
                'date'       => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'title'      => 'Nghỉ Tết',
                'note'       => 'Abcxyz',
                'date'       => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'title'      => 'Nghỉ 30/4-1/5',
                'note'       => 'Abcxyz',
                'date'       => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ]
        ];
        Holiday::insert($holiday);
    }
}
