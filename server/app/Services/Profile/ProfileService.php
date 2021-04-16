<?php

namespace App\Services\Profile;

use App\Models\User;
use App\Repositories\Contracts\LikeRepository;
use App\Repositories\Contracts\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ProfileService implements ProfileServiceInterface
{
    private $pref_lists;
    private $user_repository;
    private $like_repository;

    /**
     * Constructor
     *
     * @param UserRepository $user_repository
     */
    public function __construct(
        UserRepository $user_repository,
        LikeRepository $like_repository
    )
    {
        $this->pref_lists = config('pref');
        $this->user_repository = $user_repository;
        $this->like_repository = $like_repository;
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
                'id'               => $user->id,
                'name'             => $user->name,
                'prefecture_id'    => $user->prefecture_id,
                'pref'             => $this->pref_lists[$user->prefecture_id],
                'birthday'         => $user->birthday,
                'age'              =>  $this->calcAge($user->birthday),
                'sex'              => $user->sex,
                'sex_text'         => User::SEX_TEXT[$user->sex],
                'tweet'            => $user->profile->tweet,
                'introduction'     => $user->profile->introduction,
                'hobby'            => $user->profile->hobby,
                'blood_type'       => $user->profile->blood_type,
                'job'              => $user->profile->job,
                'image_name'       => $user->profile->image_name,
            ];
        });
        return $user;
    }


    /**
     * 全てのユーザーをプロフ付きで取得する
     *
     * @param boolean $likes_mode
     * @return Collection
     */
    public function fetchAllUsersWithProfile(bool $likes_mode): Collection
    {
        $login_user_id = Auth::id();

        $users = $this->user_repository->fetchAllWithProfile();

        // ログインユーザーは一覧に表示しないので除外
        $users = $this->rejectLoginUser($users, $login_user_id);

        $users = $this->addKeyForLoginUserAlreadyLiked($users, $login_user_id);

        if ($likes_mode) {
            $users = $this->fillterOnlyLikeRequestToLoginUser($users, $login_user_id);
        } else {
            // マッチ済ユーザーは表示しないので除外
            $users = $this->rejectMatchedUser($users, $login_user_id);
        }

        $users = $this->transformReturnValue($users);

        return $users;
    }

    /**
     * ログインユーザーとマッチ済のユーザーを除外する
     *
     * @return void
     */
    public function rejectMatchedUser(Collection $users, int $login_user_id): Collection
    {
        $matched_user_ids = $this->like_repository
            ->fetchMatchedLikes($login_user_id)
            ->pluck('request_user_id');

        if (!empty($matched_user_ids)) {
            foreach ( $matched_user_ids as $matched_user_id ) {
                $users = $users->reject(function($user) use ($matched_user_id) {
                    return $user['id'] === $matched_user_id;
                });
            }
        }
        return $users;
    }


    /**
     * ログインユーザーとマッチしているユーザだけのデータ取得
     *
     * @return Collection
     */
    public function fetchMatchedUserWithProfile(): Collection
    {
        $login_user_id = Auth::id();

        $matched_user_ids = $this->like_repository
            ->fetchMatchedLikes($login_user_id)
            ->pluck('request_user_id')
            ->toArray();

        $users = $this->user_repository->fetchMatchedUserWithProfile($matched_user_ids);

        $users = $this->transformReturnValue($users);

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
        foreach ($users as $index    => $user) {
            if ($user->likes->contains('request_user_id', $login_user_id)) {
                $users[$index]->is_already_liked  = true;
            } else {
                $users[$index]->is_already_liked  = false;
            }
        }
        return $users;
    }

    /**
     * ログインユーザーにリクエストしてきたユーザーだけに絞る
     *
     * @param Collection $users
     * @param integer $login_user_id
     * @return Collection
     */
    private function fillterOnlyLikeRequestToLoginUser(Collection $users, int $login_user_id): Collection
    {
        $like_request_user_ids = $this->like_repository
            ->fetchReceiveLike($login_user_id)
            ->pluck('request_user_id');

        $users = $users->whereIn('id', $like_request_user_ids);

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

    /**
     * リターン用にデータを加工する
     * transformで元データを加工しつつ、フラットにする
     *
     * @param Collection $users
     * @return Collection
     */
    private function transformReturnValue(Collection $users): Collection
    {
        $users->transform(function ($user) {
            return [
                'id'               => $user->id,
                'name'             => $user->name,
                'prefecture_id'    => $user->prefecture_id,
                'pref'             => $this->pref_lists[$user->prefecture_id],
                'birthday'         => $user->birthday,
                'age'              => $this->calcAge($user->birthday),
                'sex'              => $user->sex,
                'sex_text'         => User::SEX_TEXT[$user->sex],
                'tweet'            => $user->profile->tweet ?? '初めまして',
                'introduction'     => $user->profile->introduction ?? '',
                'hobby'            => $user->profile->hobby ?? '',
                'blood_type'       => $user->profile->blood_type ?? '',
                'job'              => $user->profile->job ?? '',
                'image_name'       => $user->profile->image_name ?? 'no_image.png',
                'likes_count'      => $user->likes_count ?? 0,
                'is_already_liked' => $user->is_already_liked ?? '',
            ];
        });
        return $users;
    }
}