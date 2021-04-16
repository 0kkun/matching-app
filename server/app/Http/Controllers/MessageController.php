<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\Contracts\LikeRepository;
use App\Repositories\Contracts\MessageRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\Profile\ProfileServiceInterface;

class MessageController extends Controller
{
    private $like_repository;
    private $message_repository;
    private $profile_service;

    /**
     * Constructor
     *
     * @param LikeRepository $like_repository
     */
    public function __construct(
        LikeRepository $like_repository,
        MessageRepository $message_repository,
        ProfileServiceInterface $profile_service
    )
    {
        $this->like_repository = $like_repository;
        $this->message_repository = $message_repository;
        $this->profile_service = $profile_service;
    }


    /**
     * マッチ中のユーザー情報とプロフ、メッセージを取得するAPI
     * 
     * /api/v1/message/fetch_matched_users_list
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function fetchMatchedUsersList(Request $request): JsonResponse
    {
        try {
            Log::info("[START] " . __FUNCTION__ );
            $status = 200;

            $users = $this->profile_service->fetchMatchedUserWithProfile();

            $login_user_id = Auth::id();
            $messages = $this->message_repository->fetchMessage($login_user_id);

            $data = [
                'users' => $users,
                'messages' => $messages,
                'login_user_id' => $login_user_id
            ];

            $response = [
                'status'  => $status,
                'message' => '',
                'data'    => $data,
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
     * メッセージを作成するAPI
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            Log::info("[START] " . __FUNCTION__ );
            $status = 201;

            if (!empty($request->all())) {
                $inputs = $request->all();
                $this->message_repository
                    ->createMessage($inputs['send_user_id'], $inputs['receive_user_id'], $inputs['message']);
                $message = 'created!';
            } else {
                $status = 400;
                $message = 'bad request!';
            }

            $response = [
                'status'  => $status,
                'message' => $message,
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
}
