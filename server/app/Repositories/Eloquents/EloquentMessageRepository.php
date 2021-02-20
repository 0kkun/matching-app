<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Contracts\MessageRepository;
use App\Models\Message;

class EloquentMessageRepository implements MessageRepository
{
    protected $messages;

    /**
    * @param object $messages
    */
    public function __construct(
        Message $messages
    )
    {
        $this->messages = $messages;
    }

    /**
     * メッセージを作成する
     *
     * @param integer $send_user_id
     * @param integer $receive_user_id
     * @param string $message
     * @return void
     */
    public function createMessage(int $send_user_id, int $receive_user_id, string $message): void
    {
        $params = [
            'send_user_id' => $send_user_id,
            'receive_user_id' => $receive_user_id,
            'message' => $message,
        ];
        $this->messages->create($params);
    }
}