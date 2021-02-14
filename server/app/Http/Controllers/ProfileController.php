<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Contracts\ProfileRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    private $pref_lists;
    private $profile_repository;

    /**
     * Constructor
     *
     * @param UserRepository $user_repository
     */
    public function __construct(
        ProfileRepository $profile_repository
    )
    {
        $this->pref_lists = config('pref');
        $this->profile_repository = $profile_repository;
    }

    /**
     * ログインユーザーのプロフィール情報を取得する
     * 
     * /api/v1/profile/login_user
     *
     * @return JsonResponse
     */
    public function getLoginUserProfile(): JsonResponse
    {
        try {
            Log::info("[START] " . __FUNCTION__ );
            $status = 200;

            $login_user = Auth::user();

            // 都道府県名テキストを追加
            $login_user->pref = $this->pref_lists[$login_user->prefecture_id];

            // 誕生日から逆算して年齢を追加
            $login_user->age = $this->calcAge($login_user->birthday);

            $is_exists_profile = $this->profile_repository->isExistsProfile($login_user->id);

            // プロフィール取得 or 作成取得
            if ($is_exists_profile) {
                $profile = $this->profile_repository->getProfile($login_user->id);
            } else {
                $this->profile_repository->createDefaultProfile($login_user->id);
                $profile = $this->profile_repository->getProfile($login_user->id);
            }

            $pref_lists = config('pref');

            $data = [
                'login_user' => $login_user,
                'profile'    => $profile,
                'pref_lists' => $pref_lists
            ];

            $response = [
                'status'  => $status,
                'message' => '',
                'data'    => $data,
            ];

            Log::info("[ END ] " . __FUNCTION__ . ", STATUS:" . $status);
        } catch (\Exception $e) {
            Log::info("[Exception]" . __FUNCTION__ . $e->getMessage());
            $response = ['message' => 'server error'];
        }

        return response()->json($response);
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
