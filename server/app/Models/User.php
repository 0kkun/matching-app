<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'birthday',
        'email_verified_at',
        'prefecture_id',
        'sex',
        'remember_token',
        'updated_at'
    ];

    public $timestamps = true;

    const LIMIT_SIZE = 1000;

    const SEX_TEXT = [
        1 => '男',
        2 => '女'
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

    /* ---------- リレーション定義 ---------- */

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function likes()
    {
        // receive_user_idをリレーションさせる
        return $this->hasMany(Like::class, 'receive_user_id');
    }
}
