<?php

namespace Database\Seeders;

use App\Models\CheckLogs;
use Illuminate\Database\Seeder;

class CheckLogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CheckLogs::factory(10)->create();
    }
}
