<?php

namespace App\Models;
use App\Models\BaseModel;

class LeaveQuota extends BaseModel
{
    public $table = 'leave_quotas';

    const ORIGINAL = 12;

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'member_id',
        'year',
        'quota',
        'paid_leave',
        'unpaid_leave',
        'remain',
    ];
    
    public function requests()
    {
        return $this->hasMany(LeaveRequest::class, 'member_id', 'member_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
