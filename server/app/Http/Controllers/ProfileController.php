<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    private $pref_lists;

    /**
     * Constructor
     *
     * @param UserRepository $user_repository
     */
    public function __construct(
    )
    {
        $this->pref_lists = config('pref');
    }

    /**
     * ログインユーザーのプロフィール情報を取得する
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

            $response = [
                'status' => $status,
                'message' => '',
                'data' => $login_user,
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
