<?php

namespace Database\Seeders;

use App\Models\LeaveQuota;
use Illuminate\Database\Seeder;

class LeaveQuotasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LeaveQuota::factory(1)->create();
    }
}
