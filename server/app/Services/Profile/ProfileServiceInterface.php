<?php

namespace App\Services\Profile;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface ProfileServiceInterface
{
    /**
     * プロフ付きユーザーデータを1件取得する
     *
     * @param integer $user_id
     * @return Collection
     */
    public function getUserInfoWithProfile(int $user_id): Collection;

    /**
     * 全てのユーザーをプロフ付きで取得する
     *
     * @param boolean $likes_mode - trueならいいねをリクエストしてきたユーザーだけに絞る
     * @return Collection
     */
    public function fetchAllUsersWithProfile(bool $likes_mode): Collection;

    /**
     * ログインユーザーとマッチしているユーザだけのデータ取得
     *
     * @return Collection
     */
    public function fetchMatchedUserWithProfile(): Collection;
}