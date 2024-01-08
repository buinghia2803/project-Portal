<?php

namespace App\Models;
use App\Models\BaseModel;

class LeaveRequest extends BaseModel
{
    const TYPE = ['original' => '0', 'addition' => '1'];
    const STATUS = ['sending' => '0', 'confirmed' => '1', 'approved' => '2'];
    const REMAIN = 0;

    public $table = "leave_requests";

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'member_id',
        'year',
        'type',
        'quota',
        'note',
        'status',
        'created_by',
    ];
}
