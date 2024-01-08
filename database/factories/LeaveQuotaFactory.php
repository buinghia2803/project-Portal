<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Member; 
use Carbon\Carbon;

class LeaveQuotaFactory extends Factory
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
            'quota'         => 3,
            'paid_leave'    => 12,
            'unpaid_leave'  => 12,
            'remain'        => $this->faker->numberBetween(0, 1),
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ];
    }
}
