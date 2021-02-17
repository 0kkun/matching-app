<?php

namespace App\Repositories\Eloquents;

use App\Models\Like;
use App\Repositories\Contracts\LikeRepository;

class EloquentLikeRepository implements LikeRepository
{
    protected $likes;

    /**
    * @param object $likes
    */
    public function __construct(
        Like $likes
    )
    {
        $this->likes = $likes;
    }

    /**
     * likeリクエストレコードを生成する
     *
     * @param integer $request_user_id
     * @param integer $receive_user_id
     * @return void
     */
    public function createLikeRequest(int $request_user_id, int $receive_user_id): void
    {
        $params = [
            'request_user_id' => $request_user_id,
            'receive_user_id' => $receive_user_id,
            'is_matched' => false,
        ];
        $this->likes->create($params);
    }

    /**
     * likeのステータスをマッチ状態にする
     *
     * @param integer $request_user_id
     * @param integer $receive_user_id
     * @return void
     */
    public function acceptLikeRequest(int $request_user_id, int $receive_user_id): void
    {
        // 更新対象のレコードを取得
        $update_likes_record = $this->likes
            ->where('request_user_id', $request_user_id)
            ->where('receive_user_id', $receive_user_id)
            ->first();

        if ( !is_null($update_likes_record) ) {
            $update_likes_record->is_matched = true;
            $update_likes_record->save();
        }
    }
}