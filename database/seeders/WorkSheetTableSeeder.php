<?php

namespace Database\Seeders;

use App\Models\CheckLogs;
use App\Models\Member;
use App\Models\WorkSheet;
use App\Models\Worksheets;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class WorkSheetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($d = 1; $d <= 60; $d++) {
            $timesheet_members = [];
            $check_logs = [];
            $work_date = date('Y-m-d H:i:s', strtotime(" -$d day"));
            $check_in = date('Y-m-d 08:00:00', strtotime($work_date));
            $check_out = date('Y-m-d 17:00:00', strtotime($work_date));
            $member_id_count = Member::all()->count();
            for ($member_id = 1; $member_id <= $member_id_count; $member_id++) {
                if ($this->isWeekend($work_date) != 1) {
                    $check_in_original = date('Y-m-d H:i:s', strtotime($check_in . $this->randMinutesInString(-15, 15)));
                    $check_out_original = date('Y-m-d H:i:s', strtotime($check_out . $this->randMinutesInString(-30, 60)));

                    $diff_minutes = $this->dateDiff($check_out_original, $check_in_original);

                    $late_flag = (strtotime($check_in_original) > strtotime($check_in)) ? 1 : 0;
                    $early_flag = strtotime($check_out_original) < strtotime($check_out) ? 1 : 0;

                    $diff2_minutes = 480;

                    if ($late_flag  == 1) {
                        $diff2_minutes = $this->dateDiff($check_out, $check_in_original);
                        $late_time = $this->convertToHoursMins(480 - ($diff2_minutes - 60));
                    }

                    if ($early_flag == 1) {
                        $diff2_minutes = $this->dateDiff($check_in, $check_out_original);
                        $early_time = $this->convertToHoursMins(480 - ($diff2_minutes - 60));
                    }

                    if ($late_flag  == 1 && $early_flag == 1) {
                        $diff2_minutes = $this->dateDiff($check_out_original, $check_in_original);
                    }

                    $lack = ($diff2_minutes != 480) ? $this->convertToHoursMins(480 - ($diff2_minutes - 60)) : "00:00";


                    $timesheet_members[] = [
                        'member_id' => $member_id,
                        'work_date' => date('Y-m-d', strtotime($work_date)),
                        'is_holiday' => $this->isWeekend($work_date),
                        'checkin' => null,
                        'checkin_original' => $check_in_original,
                        'checkout' => null,
                        'checkout_original' => $check_out_original,
                        'late' => ($late_flag == 1) ? $late_time : "00:00",
                        'early' => ($early_flag == 1) ? $early_time : "00:00",
                        'in_office' => $this->convertToHoursMins($diff_minutes),
                        'ot_time' => ($this->isWeekend($work_date) == 1) ? null : "00:00",
                        'work_time' => (($diff_minutes - 60) < 480) ? $this->convertToHoursMins($diff_minutes - 60) : "08:00",
                        'lack' => $lack
                    ];

                    $date_format = date('Y-m-d', strtotime($work_date));
                    // check_logs seeder
                    $check_logs[] =
                        [
                            'member_code' => "$member_id",
                            'checktime' =>  $check_in_original,
                            'date' => $date_format
                        ];

                    for ($k = 1; $k <= rand(2, 6); $k++) {
                        $checktime_random = rand(strtotime($check_in_original), strtotime($check_out_original));
                        $check_logs[] = [
                            'member_code' => "$member_id",
                            'checktime' =>  date('Y-m-d H:i:s', $checktime_random),
                            'date' => $date_format
                        ];
                    }

                    $check_logs[] =
                        [
                            'member_code' => "$member_id",
                            'checktime' =>  $check_out_original,
                            'date' => $date_format
                        ];
                } else {
                    $timesheet_members[] = [
                        'member_id' => $member_id,
                        'work_date' => date('Y-m-d', strtotime($work_date)),
                        'is_holiday' => $this->isWeekend($work_date),
                        'checkin' => null,
                        'checkin_original' => null,
                        'checkout' => null,
                        'checkout_original' => null,
                        'late' => null,
                        'early' => null,
                        'in_office' => null,
                        'ot_time' => null,
                        'work_time' => null,
                        'lack' => null
                    ];
                }
            }
            WorkSheet::insert($timesheet_members);
            CheckLogs::insert($check_logs);
        }
    }

    function randMinutesInString($from = -30, $to = 60)
    {
        $random_diff = rand($from, $to);
        return ($random_diff < 0) ? " -" . abs($random_diff) . " minutes" : " +" . abs($random_diff) . " minutes";
    }
    function isWeekend($date)
    {
        return (date('N', strtotime($date)) >= 6) ? 1 : 0;
    }

    function convertToHoursMins($time, $format = '%02d:%02d')
    {
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }

    function dateDiff($check_out, $check_in)
    {
        return round(abs(strtotime($check_out) - strtotime($check_in)) / 60, 2);
    }
}
