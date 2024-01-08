<?php

namespace App\Models;

use App\Models\BaseModel;

class MemberShift extends BaseModel
{
    public $table = 'member_shift';

    public $fillable = [
        'member_id',
        'shift_id',
        'start_date',
        'end_date',
        'free_check',
        'part_time',
        'note',
        'created_at',
        'updated_at',
        'created_by',
        'deleted_at',
    ];
}
