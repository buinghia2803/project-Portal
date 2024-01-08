<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\PointAction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PointFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'member_id'      => Member::all()->random()->id,
            'current_point'  => PointAction::all()->random()->point,
            'month_point'    => $this->faker->numberBetween(1,7),
            'total_received' => $this->faker->numberBetween(500, 1000),
            'total_spent'    => $this->faker->numberBetween(500, 1000),
            'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ];
    }
}
