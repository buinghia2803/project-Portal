<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Member as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use \DateTimeInterface;
use Illuminate\Support\Facades\Hash;

class Member extends Authenticatable
{
    use SoftDeletes, Notifiable, HasApiTokens, HasFactory;

    public $table = 'members';

    protected $hidden = [
        'password',
    ];

    const MARITAL_STATUS = [
        '1' => 'Single',
        '2' => 'Married',
        '3' => 'Divorced',
        '4' => 'Other'
    ];

    const STATUS = [
        '1'  => 'Chính thức',
        '2'  => 'Thử việc',
        '3'  => 'Cộng tác viên/Parttime',
        '4'  => 'Lao động thời vụ',
        '5'  => 'Đào tạo/Fresher',
        '-1' => 'Đã nghỉ'
    ];

    protected $fillable = [
        'id',
        'member_code',
        'full_name',
        'email',
        'password',
        'other_email',
        'phone',
        'gender',
        'marital_status',
        'avatar',
        'avatar_official',
        'birth_date',
        'permanent_address',
        'temporary_address',
        'identity_number',
        'identity_card_date',
        'identity_card_place',
        'nationality',
        'emergency_contact_name',
        'emergency_contact_relationship',
        'emergency_contact_number',
        'bank_name',
        'bank_account',
        'academic_level',
        'start_date_official',
        'status',
        'note',
        'created_at',
        'updated_at',
        'created_by',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    // public function getIsAdminAttribute()
    // {
    //     return $this->roles()->exists();
    // }

    // public function getEmailVerifiedAtAttribute($value)
    // {
    //     return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    // }

    // public function setEmailVerifiedAtAttribute($value)
    // {
    //     $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    // }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    // public function sendPasswordResetNotification($token)
    // {
    //     $this->notify(new ResetPassword($token));
    // }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function divisions()
    {
        return $this->belongsToMany(Division::class, 'division_member', 'member_id', 'division_id');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_member', 'member_id', 'team_id');
    }

    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'member_shift', 'member_id', 'shift_id');
    }

    public function point()
    {
        return $this->hasOne(Point::class);
    }

    public function pointAction()
    {
        return $this->belongsToMany(PointAction::class);
    }
}
