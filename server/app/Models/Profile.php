<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';

    protected $guarded = array('id');

    public $timestamps = true;

    /* ---------- リレーション定義 ---------- */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
