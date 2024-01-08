<?php

namespace App\Models;
use App\Models\BaseModel;

class WorkSheet extends BaseModel
{
    public $timestamps = false;

    public $table = 'worksheets';

    protected $fillable = [
        'member_id',
        'work_date',
        'is_holiday',
        'checkin',
        'checkin_original',
        'checkout',
        'checkout_original',
        'late',
        'early',
        'in_office',
        'ot_time',
        'work_time',
        'lack',
        'compensation',
        'paid_leave',
        'unpaid_leave',
        'note'
    ];
    
    public function member(){
        return $this->belongsTo(Member::class);
    }

    public static function lastday($month = '', $year = '') {
        if (empty($month)) {
           $month = date('m');
        }
        if (empty($year)) {
           $year = date('Y');
        }
        $result = strtotime("{$year}-{$month}-01");
        $result = strtotime('-1 second', strtotime('+1 month', $result));
        return date('Y-m-d 23:59:59', $result);
    }
}
