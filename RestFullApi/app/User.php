<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    const VERIFIED_USER = '1';
    const UNVERIFIED_USER = '0';

    const ADMIN_USER = 'true';
    const REGULAR_USER = 'false';

    protected $dates = ['deleted_at'];
    protected $table  = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin',
        'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
        'transactions'
    ];

    /**
     *  function to check is user already verified
     */
    public function isVerified()
    {
        return $this->verified == User::VERIFIED_USER;
    }

    /**
     * function to check is user admin or not
     */
    public function isAdmin()
    {
        return $this->admin == User::ADMIN_USER;
    }

    /**
     * function to generate verified code
     */
    public static function generateVerificationCode()
    {
        return str_random(40);
    }
    /**
     * mutator for name user
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    /**
     * accessor for name user
     */
    public function getNameAttribute($name)
    {
        return ucwords($name);
    }
}
