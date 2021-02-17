<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Like;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $receive_user = User::where('name', 'test')->first();
        $request_users = User::limit(5)->get();

        // receiveするuserを削除する (自分にlikeをしないようにする)
        $rejected_req_user = $request_users->reject(function ($request_user) {
            return $request_user->name == 'test';
        });

        // リクエスト状態のLikeを作成
        foreach ($rejected_req_user as $request_user) {
            factory(Like::class)->create([
                'request_user_id' => $request_user->id,
                'receive_user_id' => $receive_user->id
            ]);
        }
    }
}
