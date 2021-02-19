<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface LikeRepository
{
    /**
     * ユーザーが受け取ったlikeリストを取得する
     * まだマッチしていないケース
     *
     * @param integer $user_id
     * @return Collection
     */
    public function fetchReceiveLike(int $user_id): Collection;

    /**
     * likeリクエストレコードを生成する
     *
     * @param integer $request_user_id
     * @param integer $receive_user_id
     * @return void
     */
    public function createLikeRequest(int $request_user_id, int $receive_user_id): void;

    /**
     * likeのステータスをマッチ状態にする
     *
     * @param integer $request_user_id
     * @param integer $receive_user_id
     * @return void
     */
    public function acceptLikeRequest(int $request_user_id, int $receive_user_id): void;

    /**
     * 既にlikeをしているかどうか判定する
     *
     * @param integer $request_user_id
     * @param integer $receive_user_id
     * @return boolean
     */
    public function isAlreadyLiked(int $request_user_id, int $receive_user_id): bool;

    /**
     * likeレコードを1件削除する
     *
     * @param integer $request_user_id
     * @param integer $receive_user_id
     * @return void
     */
    public function deleteLikeRecord(int $request_user_id, int $receive_user_id): void;
}