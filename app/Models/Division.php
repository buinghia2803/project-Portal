<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Division extends BaseModel
{
    use SoftDeletes;
    
    public $table = "divisions";

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'division_name',
        'dm_id',
        'created_by',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const NEW_STATUS = 0;

    const LIST_STATUS = [
        "0" => "inactive",
        "1" => "active"
    ];

    public function members() 
    {
        return $this->belongsToMany(Member::class);
    }

    public function divisionManager()
    {
        return $this->belongsTo(Member::class, 'dm_id');
    }

}
