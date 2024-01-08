<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Division;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class DivisionTableSeeder extends Seeder
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
        $division = [
            [
                'id' => 1,
                'division_name' => 'Kế toán',
                'dm_id' => 1,
                'status' => 0,
                'created_by' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null
            ],
            [
                'id' => 2,
                'division_name' => 'Kinh doanh',
                'dm_id' => 2,
                'status' => 1,
                'created_by' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null
            ],
            [
                'id' => 3,
                'division_name' => 'Marketing',
                'dm_id' => 2,
                'status' => 1,
                'created_by' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null
            ],
            [
                'id' => 4,
                'division_name' => 'Sale',
                'dm_id' => 2,
                'status' => 1,
                'created_by' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null
            ]
        ];

        Division::insert($division);
    }
}
