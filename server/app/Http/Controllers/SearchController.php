<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    private $user_repository;

    /**
     * Constructor
     *
     * @param ProfileRepository $profile_repository
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

            $users = $this->user_repository->fetchAllWithProfile();

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
