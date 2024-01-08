<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'member_id'     => Member::all()->random()->id,
            'shift_id'      => Shift::all()->random()->id,
            'start_date'    => Carbon::rawCreateFromFormat('Y-m-d', '2022-02-22'),
            'end_date'      => Carbon::rawCreateFromFormat('Y-m-d', '2022-03-22'),
            'free_check'    => $this->faker->numberBetween(0, 1),
            'part_time'     => $this->faker->numberBetween(0, 1),
            'note'          => null,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'created_by'    => 1,
            'deleted_at'    => null
        ];
    }
}
