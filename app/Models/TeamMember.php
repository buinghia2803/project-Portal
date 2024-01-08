<?php

namespace App\Models;

use App\Models\BaseModel;

class TeamMember extends BaseModel
{
    public $table = 'team_member';

    public $fillable = ['member_id','team_id'];
}
