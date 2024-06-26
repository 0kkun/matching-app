<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';

    protected $fillable = [
        'tweet',
        'user_id',
        'introduction',
        'hobby',
        'blood_type',
        'job',
        'image_name',
        'updated_at'
    ];

    // 新規プロフィール作成時に入る
    const DEFAULT_PARAMS = [
        'tweet' => '何か呟いてみよう！',
        'introduction' => '自己紹介を書いて見よう！',
        'hobby' => '-',
        'blood_type' => 'unknown',
        'job' => '-',
        'image_name' => 'no_image.png',
    ];

    // 血液型
    const BLOOD_TYPE_LISTS = [
        'A', 'B', 'O', 'AB', 'unknown'
    ];

    public $timestamps = true;

    /* ---------- リレーション定義 ---------- */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
