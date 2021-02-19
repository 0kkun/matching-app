<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';

    protected $fillable = [
        'request_user_id',
        'receive_user_id',
        'is_matched',
        'updated_at',
    ];

    /* ---------- リレーション定義 ---------- */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
