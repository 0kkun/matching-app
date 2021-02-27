<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Services\Profile\ProfileServiceInterface;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    private $profile_service;

    protected $result_status;
    protected $response;
    protected $messages;

    /**
     * Constructor
     *
     * @param ProfileRepository $profile_repository
     * @param UserRepository $user_repository
     */
    public function __construct(
        ProfileServiceInterface $profile_service
    )
    {
        $this->pref_lists = config('pref');
        $this->result_status = config('api_template.result_status');
        $this->response = config('api_template.response_format');
        $this->messages = config('api_template.messages');
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

            if (Auth::check()) {
                $status = $this->result_status['success'];
                $likes_mode = false;

                // プロフ付きのユーザー情報を全件取得
                $users = $this->profile_service->fetchAllUsersWithProfile($likes_mode);

                $data = [
                    'users'      => $users,
                    'pref_lists' => $this->pref_lists
                ];

            } else {
                $status = $this->result_status['unauthorized'];
                $data = '';
            }

            $this->response = [
                'status'  => $status,
                'message' => $this->messages[$status],
                'data'    => $data,
            ];

            Log::info("[ END ] " . __FUNCTION__ . ", STATUS:" . $status);

        } catch (\Exception $e) {
            Log::info("[Exception]" . __FUNCTION__ . $e->getMessage());
            $status = $this->result_status['server_error'];;
            $this->response = [
                'status'  => $status,
                'message' => $e->getMessage(),
                'data'    => '',
            ];
        }
        return response()->json($this->response);
    }
}
