<?php

namespace Database\Seeders;

use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class NotificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notification = [
            [
                'id'             => 1,
                'published_date' => Carbon::rawCreateFromFormat('Y-m-d', '2022-03-02'),
                'subject'        => 'Chính sách bảo hiểm 2022',
                'message'        => null,
                'status'         => 0,
                'attachment'     => null,
                'created_by'     => 1,
                'published_to'   => null,
                'deleted_at'      => null,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id'             => 2,
                'published_date' => Carbon::rawCreateFromFormat('Y-m-d', '2022-03-02'),
                'subject'        => 'Giới thiệu phúc lợi công ty',
                'message'        => null,
                'status'         => 0,
                'attachment'     => null,
                'created_by'     => 1,
                'published_to'   => null,
                'deleted_at'      => null,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id'             => 3,
                'published_date' => Carbon::rawCreateFromFormat('Y-m-d', '2022-03-02'),
                'subject'        => 'Quy trình phỏng vấn',
                'message'        => null,
                'status'         => 0,
                'attachment'     => null,
                'created_by'     => 1,
                'published_to'   => null,
                'deleted_at'      => null,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ];
        Notification::insert($notification);
    }
}
