<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Contracts\ProfileRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Models\Profile;

class ProfileController extends Controller
{
    private $pref_lists;
    private $profile_repository;
    private $user_repository;

    /**
     * Constructor
     *
     * @param ProfileRepository $profile_repository
     * @param UserRepository $user_repository
     */
    public function __construct(
        ProfileRepository $profile_repository,
        UserRepository $user_repository
    )
    {
        $this->pref_lists = config('pref');
        $this->profile_repository = $profile_repository;
        $this->user_repository = $user_repository;
    }

    /**
     * ログインユーザーのプロフィール情報を取得するAPI
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
            // プロフィール取得
            $profile = $this->getProfile($login_user->id);

            $data = [
                'login_user' => $login_user,
                'profile'    => $profile,
                'pref_lists' => $this->pref_lists,
                'blood_type' => Profile::BLOOD_TYPE
            ];

            $response = [
                'status'  => $status,
                'message' => '',
                'data'    => $data,
            ];

            Log::info("[ END ] " . __FUNCTION__ . ", STATUS:" . $status);

        } catch (\Exception $e) {
            Log::info("[Exception]" . __FUNCTION__ . $e->getMessage());
            $status = 500;
            $response = [
                'status' => $status,
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($response);
    }


    /**
     * プロフィール更新API
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateProfile(Request $request): JsonResponse
    {
        try {
            Log::info("[START] " . __FUNCTION__ );

            $status = 200;

            $login_user = Auth::user();

            $inputs = $request->all();

            // テーブルアップデート処理
            if ( !empty($inputs) ) {
                $this->profile_repository->updateProfile($login_user->id, $inputs['profile']);
                $this->user_repository->updateUser($login_user->id, $inputs['user']);
            } else {
                $status = 204;
            }

            $response = [
                'status'  => $status,
                'message' => '',
                'data'    => '',
            ];

            Log::info("[ END ] " . __FUNCTION__ . ", STATUS:" . $status);

        } catch (\Exception $e) {
            Log::info("[Exception]" . __FUNCTION__ . $e->getMessage());
            $status = 500;
            $response = [
                'status' => $status,
                'message' => $e->getMessage(),
            ];
        }
        return response()->json($response);
    }


    /**
     * 画像アップロードAPI
     * TODO: S3に保存できるようにする
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function imageUpload(Request $request): JsonResponse
    {
        try {
            Log::info("[START] " . __FUNCTION__ );

            $status = 200;

            $file = $request->file;
            // 画像保存処理
            if ( !empty($file) ) {
                $file_name = $file->getClientOriginalName();
                $target_path = public_path('/images/uploads/');
                $file->move($target_path, $file_name);
            } else {
                $status = 204;
            }

            $response = [
                'status'  => $status,
                'message' => '',
                'data'    => '',
            ];
        } catch (\Exception $e) {
            Log::info("[Exception]" . __FUNCTION__ . $e->getMessage());
            $status = 500;
            $response = [
                'status' => $status,
                'message' => $e->getMessage(),
            ];
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


    /**
     * ログインユーザーのプロフィールを取得する
     *
     * @param integer $user_id
     * @return Collection
     */
    private function getProfile(int $user_id): Collection
    {
        // 存在確認
        $is_exists_profile = $this->profile_repository->isExistsProfile($user_id);

        // プロフィール取得 or 作成取得
        if ($is_exists_profile) {
            $profile = $this->profile_repository->getProfile($user_id);
        } else {
            $this->profile_repository->createDefaultProfile($user_id);
            $profile = $this->profile_repository->getProfile($user_id);
        }
        return $profile;
    }
}
