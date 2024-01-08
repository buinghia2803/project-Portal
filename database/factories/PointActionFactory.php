<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\PointAction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PointActionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // return [
        //     'member_id'      => Member::all()->random()->id,
        //     'date'           => Carbon::now()->format('Y-m-d H:i:s'),
        //     'month'          => $this->faker->date('2022-03'),
        //     'year'           => $this->faker->date('2022'),
        //     'action'         => $this->faker->randomElement(['Action 1', 'Action 2', 'Action 3']),
        //     'point'          => $this->faker->numberBetween(-500, 1000),
        //     'status'         => $this->faker->numerify(0),
        //     'created_by'     => $this->faker->numberBetween(1, 5),
        //     'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        //     'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        // ];
    }
}
