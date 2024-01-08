<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Member;
use Carbon\Carbon;

class LeaveRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'member_id'     => 4,
            'year'          => Carbon::now()->format('Y'),
            'type'          => $this->faker->numberBetween(0, 1),
            'quota'         => $this->faker->numberBetween(20, 30),
            'note'          => $this->faker->sentence,
            'status'        => $this->faker->numberBetween(0, 2),
            'created_by'    => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ];
    }
}
