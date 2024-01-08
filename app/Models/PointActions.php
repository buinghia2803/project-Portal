<?php

namespace App\Models;
use App\Models\BaseModel;

class PointActions extends BaseModel
{
    public $table = 'point_actions';

    protected $fillable = [
        'member_id',
        'data',
        'month',
        'year',
        'action',
        'point',
        'status',
        'created_by',
        'created_at',
        'updated_at'
    ];

}