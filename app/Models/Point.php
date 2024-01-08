<?php

namespace App\Models;
use App\Models\BaseModel;

class Point extends BaseModel
{
    public $table = 'points';

    protected $fillable = [
        'member_id',
        'current_point',
        'month_point',
        'total_received',
        'total_spent',
        'created_at',
        'updated_at',
    ];
}
