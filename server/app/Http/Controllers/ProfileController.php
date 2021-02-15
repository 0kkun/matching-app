<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Contracts\ProfileRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Models\Profile;
use App\Services\Profile\ProfileServiceInterface;

class ProfileController extends Controller
{
    private $pref_lists;
    private $profile_repository;
    private $user_repository;
    private $profile_service;

    /**
     * Constructor
     *
     * @param ProfileRepository $profile_repository
     * @param UserRepository $user_repository
     */
    public function __construct(
        ProfileRepository $profile_repository,
        UserRepository $user_repository,
        ProfileServiceInterface $profile_service
    )
    {
        $this->pref_lists = config('pref');
        $this->profile_repository = $profile_repository;
        $this->user_repository = $user_repository;
        $this->profile_service = $profile_service;
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

            $login_user_id = Auth::id();

            $this->checkProfileAndCreate($login_user_id);

            $login_user = $this->profile_service->getUserInfoWithProfile($login_user_id);

            $data = [
                'login_user' => $login_user,
                'pref_lists' => $this->pref_lists,
                'blood_type_lists' => Profile::BLOOD_TYPE_LISTS
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

            $login_user_id = Auth::id();

            $inputs = $request->all();

            // テーブルアップデート処理
            if ( !empty($inputs) ) {
                $this->profile_repository->updateProfile($login_user_id, $inputs['profile']);
                $this->user_repository->updateUser($login_user_id, $inputs['user']);
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
     * プロフィールが存在するか確認し、無ければ作成する
     *
     * @param integer $user_id
     * @return Collection
     */
    private function checkProfileAndCreate(int $user_id): void
    {
        // 存在確認
        $is_exists_profile = $this->profile_repository->isExistsProfile($user_id);

        // プロフィールが存在しなければ作成
        if (!$is_exists_profile) {
            $this->profile_repository->createDefaultProfile($user_id);
        }
    }
}
