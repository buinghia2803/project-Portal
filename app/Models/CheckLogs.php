<?php

namespace App\Models;

use App\Models\BaseModel;

class CheckLogs extends BaseModel
{
    public $table = 'check_log';

    public $fillable = ['member_code','checktime','date','created_at'];
}
