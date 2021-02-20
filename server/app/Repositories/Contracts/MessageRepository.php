<?php

namespace App\Repositories\Contracts;

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
}