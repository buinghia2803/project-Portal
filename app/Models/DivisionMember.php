<?php

namespace App\Models;

use App\Models\BaseModel;

class DivisionMember extends BaseModel
{
    public $table = 'division_member';

    public $fillable = ['member_id','division_id'];
}
