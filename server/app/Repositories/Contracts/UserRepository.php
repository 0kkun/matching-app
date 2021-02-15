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

    /**
     * プロフィールを更新する
     * NOTE: Eloquent Modelとしてアップデートする
     *
     * @param integer $user_id
     * @param array $inputs
     * @return void
     */
    public function updateUser(int $user_id, array $inputs): void;

    /**
     * プロフデータ付きで全てのユーザーを取得する
     *
     * @return Collection
     */
    public function fetchAllWithProfile(): Collection;
}