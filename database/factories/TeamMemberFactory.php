<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'member_id'  => Member::all()->random()->id,
            'team_id'    => Team::all()->random()->id,
            'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ];
    }
}
