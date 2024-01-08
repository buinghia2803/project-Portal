<?php

namespace App\Models;

use App\Models\BaseModel;

class MemberRequestQuota extends BaseModel
{
    const QUOTA = 3;
    const REMAIN = 3;

    public $table = 'member_request_quotas';

    protected $fillable = [
        'member_id',
        'month',
        'quota',
        'remain',
        'created_at',
        'updated_at',
    ];
}
