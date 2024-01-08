<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class RequestModel extends BaseModel
{
    use SoftDeletes;

    public $table = 'requests';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'member_id',
        'request_type',
        'request_for_date',
        'check_in',
        'check_out',
        'compensation_time',
        'compensation_date',
        'leave_all_day',
        'leave_start',
        'leave_end',
        'leave_time',
        'request_ot_time',
        'reason',
        'status',
        'manager_id',
        'manager_confirmed_status',
        'manager_confirmed_at',
        'manager_confirmed_comment',
        'admin_id',
        'admin_approved_status',
        'admin_approved_at',
        'admin_approved_comment',
        'error_count',
    ];

    static function get_request($request_for_date)
    {
        try {
            $requests = RequestModel::select([
                'id',
                'request_type',
                'status',
                'request_for_date',
                'check_in',
                'check_out',
                'reason',
                'compensation_date',
                'compensation_time',
                'leave_all_day',
                'leave_start',
                'leave_end',
                'leave_time',
                'request_ot_time',
                'error_count'
            ])->where('member_id', Auth::user()->id)->where('request_for_date', $request_for_date)->get();
            return $requests;
        } catch (\Error $error) {
            return $requests = null;
        }
    }

    const REQUESTS_STATUS = [
        '-1' => '-1', //reject
        '0'  => '0',  //sent
        '1'  => '1',  //confirmed
        '2'  => '2'   //approved
    ];

    protected $appends = ['member_full_name'];

    public function members()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function getMemberFullNameAttribute()
    {
        return $this->members ? $this->members->full_name : '';
    }

    public function manager()
    {
        return $this->belongsTo(Member::class, 'manager_id', 'id');
    }
}
