<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface ProfileRepository
{
    /**
     * user_idでプロフィールデータを取得する
     *
     * @param integer $user_id
     * @return Collection
     */
    public function getProfile(int $user_id): Collection;

    /**
     * 引数で指定されたユーザーのプロフィールが存在するかどうか
     *
     * @param integer $user_id
     * @return boolean
     */
    public function isExistsProfile(int $user_id): bool;

    /**
     * 初期のデフォルトプロフィールを作成
     *
     * @param integer $user_id
     * @return void
     */
    public function createDefaultProfile(int $user_id): void;

    /**
     * プロフィールを更新する
     * NOTE: Eloquent Modelとしてアップデートする
     *
     * @param integer $user_id
     * @param array $inputs
     * @return void
     */
    public function updateProfile(int $user_id, array $inputs): void;
}