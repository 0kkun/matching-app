<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Contracts\UserRepository;
use Illuminate\Support\Collection;
use App\Models\User;

class EloquentUserRepository implements UserRepository
{
    protected $users;

    /**
    * @param object $users
    */
    public function __construct(
        User $users
    )
    {
        $this->users = $users;
    }

    /**
     * 全てのユーザーを取得する
     *
     * @return Collection
     */
    public function fetchAll(): Collection
    {
        return $this->users->get();
    }

    /**
     * idでユーザー情報を取得する
     *
     * @param integer $user_id
     * @return Collection
     */
    public function getByUserId(int $user_id): Collection
    {
        return $this->users->where('id', $user_id)->get();
    }

    /**
     * プロフィールを更新する
     * NOTE: Eloquent Modelとしてアップデートする
     *
     * @param integer $user_id
     * @param array $inputs
     * @return void
     */
    public function updateUser(int $user_id, array $inputs): void
    {
        $this->users
            ->find($user_id)
            ->fill($inputs)
            ->save();
    }

    /**
     * プロフデータ付きで全てのユーザーを取得する
     *
     * @return Collection
     */
    public function fetchAllWithProfile(): Collection
    {
        return $this->users
            ->with('profile')
            ->limit(User::LIMIT_SIZE)
            ->get();
    }
}