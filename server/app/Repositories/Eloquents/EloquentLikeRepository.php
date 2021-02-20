<?php

namespace App\Repositories\Eloquents;

use App\Models\Like;
use App\Repositories\Contracts\LikeRepository;
use Illuminate\Support\Collection;

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
     * ユーザーが受け取ったlikeリストを取得する
     * まだマッチしていないケース
     *
     * @param integer $user_id
     * @return Collection
     */
    public function fetchReceiveLike(int $user_id): Collection
    {
        return $this->likes
            ->where('receive_user_id', $user_id)
            ->where('is_matched', false)
            ->get();
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
        // 自分にlikeできないようにする
        if ($request_user_id !== $receive_user_id) {
            $params = [
                'request_user_id' => $request_user_id,
                'receive_user_id' => $receive_user_id,
                'is_matched' => false,
            ];
            $this->likes->create($params);
        }
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
        // リクエスト側の更新対象のレコードを取得
        $update_requestor_likes_record = $this->likes
            ->where('request_user_id', $receive_user_id)
            ->where('receive_user_id', $request_user_id)
            ->first();

        // レシーバ川の更新対象レコード取得
        $update_receiver_likes_record = $this->likes
            ->where('request_user_id', $request_user_id)
            ->where('receive_user_id', $receive_user_id)
            ->first();

        // 更新
        if ( !is_null($update_requestor_likes_record) ) {
            $update_requestor_likes_record->is_matched = true;
            $update_requestor_likes_record->save();
        }
        if ( !is_null($update_requestor_likes_record) ) {
            $update_receiver_likes_record->is_matched = true;
            $update_receiver_likes_record->save();
        }
    }

    /**
     * 既にlikeをしているかどうか判定する
     *
     * @param integer $request_user_id
     * @param integer $receive_user_id
     * @return boolean
     */
    public function isAlreadyLiked(int $request_user_id, int $receive_user_id): bool
    {
        return $this->likes
            ->where('request_user_id', $request_user_id)
            ->where('receive_user_id', $receive_user_id)
            ->exists();
    }

    /**
     * likeレコードを1件削除する
     *
     * @param integer $request_user_id
     * @param integer $receive_user_id
     * @return void
     */
    public function deleteLikeRecord(int $request_user_id, int $receive_user_id): void
    {
        $this->likes
            ->where('request_user_id', $request_user_id)
            ->where('receive_user_id', $receive_user_id)
            ->limit(1)
            ->delete();
    }

    /**
     * 相手が既にlikeをしているかどうか判定する
     *
     * @param integer $request_user_id
     * @param integer $receive_user_id
     * @return boolean
     */
    public function isReceiveUserAlreadyLiked(int $request_user_id, int $receive_user_id): bool
    {
        return $this->likes
            ->where('request_user_id', $receive_user_id)
            ->where('receive_user_id', $request_user_id)
            ->exists();
    }

    /**
     * マッチ中のlikesデータを取得する
     *
     * @param integer $login_user_id
     * @return Collection
     */
    public function fetchMatchedLikes(int $login_user_id): Collection
    {
        return $this->likes
            ->where('is_matched', true)
            ->where('receive_user_id', $login_user_id)
            ->get();
    }
}