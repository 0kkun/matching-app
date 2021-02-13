<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface UserRepository
{
    /**
     * 全てのユーザーを取得する
     *
     * @return Collection
     */
    public function fetchAll(): Collection;

    /**
     * idでユーザー情報を取得する
     *
     * @param integer $user_id
     * @return Collection
     */
    public function getByUserId(int $user_id): Collection;
}