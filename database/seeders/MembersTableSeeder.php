<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Member;
use Illuminate\Database\Seeder;
use Nette\Utils\Random;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class MembersTableSeeder extends Seeder
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
        $member = [
            [
                'id'                                => 1,
                'member_code'                       => 412,
                'full_name'                         => 'Phạm Văn Thắng',
                'email'                             => 'thangpv@relipasoft.com',
                'password'                          => bcrypt('abcd1234'),
                'other_email'                       => 'vanthangp@gmail.com',
                'phone'                             => '0123456789',
                'gender'                            => 0,
                'marital_status'                    => 1,
                'avatar'                            => null,
                'avatar_official'                   => null,
                'birth_date'                        => Carbon::rawCreateFromFormat('Y-m-d', '1997-06-08'),
                'permanent_address'                 => 'Hải Dương',
                'temporary_address'                 => 'Hà Nội',
                'identity_number'                   => '030200003088',
                'identity_card_date'                => Carbon::rawCreateFromFormat('Y-m-d', '2016-10-13'),
                'identity_card_place'               => 'Hải Dương',
                'nationality'                       => 'Vietnam',
                'emergency_contact_name'            => 'Nguyễn Văn A',
                'emergency_contact_relationship'    => 'Bố',
                'emergency_contact_number'          => '0124564835',
                'academic_level'                    => 'Đại học',
                'bank_name'                         => 'Techcombank',
                'bank_account'                      => '19033984347010',
                'status'                            => 1,
                'note'                              => 'Hi',
                'created_at'                        => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'                        => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by'                        => 1,
                'deleted_at'                        => null
            ],
        ];
        for ($i = 2; $i < 10; $i++) {
            $member[] = [
                'id'                                => $i,
                'member_code'                       => $this->faker->numberBetween(100, 1000),
                'full_name'                         => $this->faker->name,
                'email'                             => $this->faker->unique()->email,
                'password'                          => bcrypt('abcd1234'),
                'other_email'                       => $this->faker->unique()->email,
                'phone'                             => $this->faker->numerify('##########'),
                'gender'                            => $this->faker->numberBetween(0, 1),
                'marital_status'                    => $this->faker->numberBetween(0, 1),
                'avatar'                            => null,
                'avatar_official'                   => null,
                'birth_date'                        => Carbon::rawCreateFromFormat('Y-m-d', '1997-06-08'),
                'permanent_address'                 => $this->faker->address,
                'temporary_address'                 => $this->faker->address,
                'identity_number'                   => $this->faker->numerify('##########'),
                'identity_card_date'                => Carbon::rawCreateFromFormat('Y-m-d', '2016-10-13'),
                'identity_card_place'               => Str::random(16),
                'nationality'                       => $this->faker->country,
                'emergency_contact_name'            => $this->faker->name,
                'emergency_contact_relationship'    => $this->faker->randomElement(['Bố', 'Mẹ']),
                'emergency_contact_number'          => $this->faker->numerify('##########'),
                'academic_level'                    => $this->faker->randomElement(['Đại học', 'Cao đẳng']),
                'bank_name'                         => $this->faker->randomElement(['MB', 'Teachcombank', 'Vietcombank', 'Tp bank']),
                'bank_account'                      => $this->faker->numerify('#############'),
                'status'                            =>  $this->faker->numberBetween(0, 1),
                'note'                              => Str::random(16),
                'created_at'                        => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'                        => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by'                        => $this->faker->numberBetween(0, 1),
                'deleted_at'                        => null
            ];
        }
        Member::insert($member);
    }
}
