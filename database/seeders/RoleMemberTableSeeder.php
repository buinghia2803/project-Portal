<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class RoleMemberTableSeeder extends Seeder
{
    public function run()
    {
        Member::findOrFail(1)->roles()->sync(1);
    }
}
