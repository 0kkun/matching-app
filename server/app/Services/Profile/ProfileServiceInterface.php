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
     * @return Collection
     */
    public function fetchAllUsersWithProfile(): Collection;
}