<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class TeamsTableSeeder extends Seeder
{
    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;


    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $team = [
            [
                'id' => 1,
                'team_name' => 'Nhóm đồ án',
                'leader_id' => 3,
                'status' => 0,
                'created_by' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null
            ],
            [
                'id' => 2,
                'team_name' => 'Nhóm học web',
                'leader_id' => 4,
                'status' => 1,
                'created_by' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null
            ],
            [
                'id' => 3,
                'team_name' => 'Nhóm học AI',
                'leader_id' => 4,
                'status' => 1,
                'created_by' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null
            ],
            [
                'id' => 4,
                'team_name' => 'Nhóm đi chơi',
                'leader_id' => 4,
                'status' => 1,
                'created_by' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null
            ],
        ];

        Team::insert($team);
    }
}
