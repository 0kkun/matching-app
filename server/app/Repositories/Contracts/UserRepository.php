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

    /**
     * プロフデータ付きでユーザーデータを取得する
     *
     * @return Collection
     */
    public function getWithProfile(int $user_id): Collection;

    /**
     * マッチ中のユーザーデータを取得する
     * 同時にprofilesとlikesとcommentsも取得する
     *
     * @param array $matched_user_ids
     * @return Collection
     */
    public function fetchMatchedUserWithProfAndComment(array $matched_user_ids): Collection;
}