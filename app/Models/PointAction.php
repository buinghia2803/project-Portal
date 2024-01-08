<?php

namespace App\Models;

use App\Models\BaseModel;

class PointAction extends BaseModel
{
    public $table = 'point_actions';

    protected $fillable = [
        'member_id',
        'date',
        'month',
        'year',
        'action',
        'point',
        'status',
        'created_by',
        'created_at',
        'updated_at',
    ];

    const NEW_STATUS = 0;

    public function member(){
        return $this->belongsTo('App\Models\Member', 'member_id', 'id');
    }
}
