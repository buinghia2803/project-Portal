<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends BaseModel
{
    use SoftDeletes;

    public $table = 'teams';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'team_name',
        'leader_id',
        'created_by',
        'status',
    ];

    const NEW_STATUS = 0;

    const LIST_STATUS = [
        "0" => "inactive",
        "1" => "active"
    ];

    public function members() 
    {
        return $this->belongsToMany(Member::class, 'team_member', 'team_id', 'member_id');
    }

    public function teamLeader()
    {
        return $this->belongsTo(Member::class, 'leader_id');
    }
}
