<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\Contracts\LikeRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\Profile\ProfileServiceInterface;

class LikeController extends Controller
{
    private $like_repository;
    private $profile_service;

    /**
     * Constructor
     *
     * @param LikeRepository $like_repository
     */
    public function __construct(
        LikeRepository $like_repository,
        ProfileServiceInterface $profile_service
    )
    {
        $this->like_repository = $like_repository;
        $this->profile_service = $profile_service;
    }


    /**
     * いいねをリクエストしてきたユーザーリストを取得する
     * まだマッチしていないもの
     * 
     * /api/v1/like/fetch_users_list
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function fetchUsersList(Request $request): JsonResponse
    {
        try {
            Log::info("[START] " . __FUNCTION__ );
            $status = 200;
            $likes_mode = true;

            // プロフ付きのユーザー情報を全件取得
            $users = $this->profile_service->fetchAllUsersWithProfile($likes_mode);

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


    /**
     * いいねボタン押下時のアクション
     * まだ押されていなかったら追加、既に押されていたら削除
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createLikeRequest(Request $request)
    {
        try {
            Log::info("[START] " . __FUNCTION__ );
            if ($request->has('receive_user_id')) {

                $request_user_id = Auth::id();
                $receive_user_id = $request->receive_user_id;

                // 自分自身にいいねを押させないためのエラーハンドリング
                if ($request_user_id === $receive_user_id) {
                    $status = 251;
                    $response = ['status' => $status, 'message' => 'Error! cannot request to myself.'];
                    return response()->json($response);
                }

                // 既に存在していた場合の処理
                if ($this->like_repository->isAlreadyLiked($request_user_id, $receive_user_id) ) {
                    $this->like_repository->deleteLikeRecord($request_user_id, $receive_user_id);
                    $status = 204;
                    $response = ['status' => $status, 'message' => 'Likes record deleted!'];
                    return response()->json($response);
                }

                $this->like_repository->createLikeRequest($request_user_id, $receive_user_id);
                $status = 201;
                $message = 'created!';
            } else {
                $status = 400;
                $message = 'bad request';
            }
            $response = [
                'status'  => $status,
                'message' => $message,
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
