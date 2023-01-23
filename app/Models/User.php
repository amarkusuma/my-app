<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use App\Notifications\SendOTPLoginNotification;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;
    // use SoftDeletes;
    use HasRoles;
    use HasFactory;
    use HasApiTokens;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'remember_token', 'phone_number', 'age', 'gender', 'city', 'level', 'bill', 'otp_code', 'otp_code_updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'deleted_at'
    ];

    protected $attributes = [
        'menuroles' => 'user',
    ];


    public function getEmailForVerification()
    {
        return strtolower($this->email);
    }

    public function getNameForVerification()
    {
        return $this->name;
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification());
    }

    public function sendOTPLoginNotification()
    {
        $this->notify(new SendOTPLoginNotification());
    }

    public function sendResetPasswordNotification()
    {
        $this->notify(new ResetPasswordNotification());
    }

    public function member_learn()
    {
        return $this->hasMany(MemberLearn::class, 'user_id');
    }
}
