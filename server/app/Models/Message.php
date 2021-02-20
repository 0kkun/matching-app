<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'send_user_id',
        'receive_user_id',
        'message',
        'updated_at',
    ];
}
