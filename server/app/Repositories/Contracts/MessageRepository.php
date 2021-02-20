<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface MessageRepository
{
    /**
     * メッセージを作成する
     *
     * @param integer $send_user_id
     * @param integer $receive_user_id
     * @param string $message
     * @return void
     */
    public function createMessage(int $send_user_id, int $receive_user_id, string $message): void;

    /**
     * ログインユーザーが持っているメッセージを取得する
     *
     * @param integer $login_user_id
     * @return Collection
     */
    public function fetchMessage(int $login_user_id): Collection;
}