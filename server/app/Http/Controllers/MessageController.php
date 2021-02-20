<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\Contracts\LikeRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\Profile\ProfileServiceInterface;

class MessageController extends Controller
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


    public function fetchMatchedUsersList(Request $request): JsonResponse
    {
        try {
            Log::info("[START] " . __FUNCTION__ );
            $status = 200;

            // コメントデータと一緒にログインユーザーとマッチしているユーザだけの一覧を取得する
            // メッセージ画面から相手のプロフも確認したいのでプロフィール情報もつける
            // 要約すると、マッチしているユーザー with プロフィール with コメント
            $users = $this->profile_service->fetchMatchedUserWithProfAndComment();

            $response = [
                'status'  => $status,
                'message' => '',
                'data'    => $users,
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
