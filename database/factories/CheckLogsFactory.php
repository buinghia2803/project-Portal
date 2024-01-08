<?php

namespace Database\Factories;

use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CheckLogsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'member_code'   => Member::all()->random()->member_code,
            'checktime'     => Carbon::now()->format('Y-m-d H:i:s'),
            'date'          => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ];
    }
}
