<?php

namespace Database\Seeders;

use App\Models\MemberShift;
use Illuminate\Database\Seeder;

class MemberShiftTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MemberShift::factory(10)->create();
    }
}
