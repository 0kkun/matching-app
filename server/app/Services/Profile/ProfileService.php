<?php

namespace App\Services\Profile;

use App\Models\User;
use Carbon\Carbon;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ProfileService implements ProfileServiceInterface
{
    private $pref_lists;
    private $user_repository;

    /**
     * Constructor
     *
     * @param UserRepository $user_repository
     */
    public function __construct(
        UserRepository $user_repository
    )
    {
        $this->pref_lists = config('pref');
        $this->user_repository = $user_repository;
    }


    /**
     * プロフ付きユーザーデータを1件取得する
     *
     * @param integer $user_id
     * @return Collection
     */
    public function getUserInfoWithProfile(int $user_id): Collection
    {
        $user = $this->user_repository->getWithProfile($user_id);

        // transformで元データを加工しつつ、フラットにする
        $user->transform(function ($user) {
            return [
                'id'            => $user->id,
                'name'          => $user->name,
                'prefecture_id' => $user->prefecture_id,
                'pref'          => $this->pref_lists[$user->prefecture_id],
                'birthday'      => $user->birthday,
                'age'           =>  $this->calcAge($user->birthday),
                'sex'           => $user->sex,
                'sex_text'      => User::SEX_TEXT[$user->sex],
                'tweet'         => $user->profile->tweet,
                'introduction'  => $user->profile->introduction,
                'hobby'         => $user->profile->hobby,
                'blood_type'    => $user->profile->blood_type,
                'job'           => $user->profile->job,
                'image_name'    => $user->profile->image_name,
            ];
        });
        return $user;
    }


    /**
     * 全てのユーザーをプロフ付きで取得する
     *
     * @return Collection
     */
    public function fetchAllUsersWithProfile(): Collection
    {
        $users = $this->user_repository->fetchAllWithProfile();
        $login_user_id = Auth::id();

        $users = $this->rejectLoginUser($users, $login_user_id);

        $users = $this->addKeyForLoginUserAlreadyLiked($users, $login_user_id);

        // transformで元データを加工しつつ、フラットにする
        $users->transform(function ($user) {
            return [
                'id'            => $user->id,
                'name'          => $user->name,
                'prefecture_id' => $user->prefecture_id,
                'pref'          => $this->pref_lists[$user->prefecture_id],
                'birthday'      => $user->birthday,
                'age'           =>  $this->calcAge($user->birthday),
                'sex'           => $user->sex,
                'sex_text'      => User::SEX_TEXT[$user->sex],
                'tweet'         => $user->profile->tweet,
                'introduction'  => $user->profile->introduction,
                'hobby'         => $user->profile->hobby,
                'blood_type'    => $user->profile->blood_type,
                'job'           => $user->profile->job,
                'image_name'    => $user->profile->image_name,
                'likes_count'   => $user->likes_count,
                'is_already_liked' => $user->is_already_liked,
            ];
        });
        return $users;
    }


    /**
     * ログイン中のユーザーは一覧から除外する
     *
     * @param Collection $users
     * @param integer $login_user_id
     * @return Collection
     */
    private function rejectLoginUser(Collection $users, int $login_user_id): Collection
    {
        return $users->reject(function($user) use ($login_user_id) {
            return $user['id'] === $login_user_id;
        });
    }


    /**
     * ログインユーザーが既にいいねを押しているかどうかのキーを加える
     *
     * @param Collection $users
     * @param integer $login_user_id
     * @return Collection
     */
    private function addKeyForLoginUserAlreadyLiked(Collection $users, int $login_user_id): Collection
    {
        foreach ($users as $index => $user) {
            if ($user->likes->contains('request_user_id', $login_user_id)) {
                $users[$index]->is_already_liked  = true;
            } else {
                $users[$index]->is_already_liked  = false;
            }
        }
        return $users;
    }


    /**
     * 誕生日から逆算して年齢を出す
     *
     * @param string $birthday
     * @return integer
     */
    private function calcAge(string $birthday): int
    {
        $now = Carbon::now()->format('Ymd');
        // ハイフン削除
        $birthday = str_replace("-", "", $birthday);

        return (int) floor(($now-$birthday) / 10000);
    }
}