<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\Contracts\LikeRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LikeController extends Controller
{
    private $like_repository;

    /**
     * Constructor
     *
     * @param LikeRepository $like_repository
     */
    public function __construct(
        LikeRepository $like_repository
    )
    {
        $this->like_repository = $like_repository;
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
