<?php

namespace App\Models;

use App\Models\BaseModel;

use Illuminate\Support\Facades\Auth;

class Worksheets extends BaseModel
{
    public $table = 'worksheets';

    public $timestamps = false;

    protected $fillable = [
        'member_id',
        'work_date',
        'is_holiday',
        'checkin',
        'check_in',
        'check_out',
        'checkin_original',
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
        'note',
    ];


}
