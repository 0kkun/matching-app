<?php

use App\Models\Message;
use Illuminate\Database\Seeder;
use App\Models\User;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $send_user = User::where('name', 'test')->first();

        $receive_users = User::limit(5)->get();
        $rejected_receive_users = $receive_users->reject(function ($request_user) {
            return $request_user->name == 'test';
        });

        foreach ($rejected_receive_users as $receive_user) {
            // 送信したメッセージ作成
            factory(Message::class, 5)->create([
                'send_user_id' => $send_user->id,
                'receive_user_id' => $receive_user->id
            ]);

            // 受信したメッセージ作成
            factory(Message::class, 5)->create([
                'send_user_id' => $receive_user->id,
                'receive_user_id' => $send_user->id,
            ]);
        }
    }
}
