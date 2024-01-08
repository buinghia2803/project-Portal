<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BaseModel;
use Carbon\Carbon;

class Holiday extends BaseModel
{
    use SoftDeletes;

    public $table = 'holidays';

    protected $fillable = [
        'title',
        'note',
        'date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
