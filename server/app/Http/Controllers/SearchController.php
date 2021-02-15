<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Services\Profile\ProfileServiceInterface;

class SearchController extends Controller
{
    private $user_repository;
    private $profile_service;

    /**
     * Constructor
     *
     * @param ProfileRepository $profile_repository
     * @param UserRepository $user_repository
     */
    public function __construct(
        UserRepository $user_repository,
        ProfileServiceInterface $profile_service
    )
    {
        $this->pref_lists = config('pref');
        $this->user_repository = $user_repository;
        $this->profile_service = $profile_service;
    }


    /**
     * ユーザーリストを取得する
     * 
     * /api/v1/search/fetch_users_list
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function fetchUsersList(Request $request): JsonResponse
    {
        try {
            Log::info("[START] " . __FUNCTION__ );
            $status = 200;

            // プロフ付きのユーザー情報を全件取得
            $users = $this->profile_service->fetchAllUsersWithProfile();

            $response = [
                'status'  => $status,
                'message' => '',
                'data'    => $users,
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
}
