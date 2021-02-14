<?php

namespace App\Repositories\Eloquents;

use App\Models\Profile;
use App\Repositories\Contracts\ProfileRepository;
use Illuminate\Support\Collection;

class EloquentProfileRepository implements ProfileRepository
{
    protected $profiles;

    /**
    * @param object $users
    */
    public function __construct(
        Profile $profiles
    )
    {
        $this->profiles = $profiles;
    }

    /**
     * user_idでプロフィールデータを取得する
     *
     * @param integer $user_id
     * @return Collection
     */
    public function getProfile(int $user_id): Collection
    {
        return $this->profiles
            ->where('user_id', $user_id)
            ->get();
    }

    /**
     * 引数で指定されたユーザーのプロフィールが存在するかどうか
     *
     * @param integer $user_id
     * @return boolean
     */
    public function isExistsProfile(int $user_id): bool
    {
        return $this->profiles
            ->where('user_id', $user_id)
            ->exists();
    }

    /**
     * 初期のデフォルトプロフィールを作成
     *
     * @param integer $user_id
     * @return void
     */
    public function createDefaultProfile(int $user_id): void
    {
        $this->profiles->create(['user_id' => $user_id]);
    }

    /**
     * プロフィールを更新する
     * NOTE: Eloquent Modelとしてアップデートする
     *
     * @param integer $user_id
     * @param array $inputs
     * @return void
     */
    public function updateProfile(int $user_id, array $inputs): void
    {
        $update_profile = $this->profiles->where('user_id', $user_id)->first();

        $this->profiles->find($update_profile->id)
            ->fill($inputs)
            ->save();
    }
}