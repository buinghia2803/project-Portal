<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends BaseModel
{
    use SoftDeletes;
    
    public $table = 'notifications';

    protected $fillable = [
        'published_date',
        'subject',
        'message',
        'status',
        'attachment',
        'created_by',
        'published_to',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    const STATUS = [
        '0' => 'Draft',
        '1' => 'Published'
    ];

    public function division_member(){
        return $this->belongsTo(DivisionMember::class);
    }
}
