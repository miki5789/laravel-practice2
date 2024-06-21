<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function show(){
        return productMaster::all();
    }
   
    function errorCheck(Request $request){
        //ログの中に詳細を仕込む
        //ログの詳細：
        //だれが　どの画面で　エラーの内容 どんなリクエスト　
        //ログID発行
        \Log::info('errorLog:'); 
        
        $errorData = $request->all();
        \Log::info($errorData); 
        $status_code = $errorData['status'];
        $url = $errorData['config']['url'];
        //$message = $errorData['message'];

        switch ($status_code) {
            case 400:
                $message = 'リクエストに失敗しました';
                break;
            case 401:
                $message = '認証に失敗しました';
                break;
            case 403:
                $message = 'アクセス権がありません';
                break;
            case 404:
                $message = '存在しないページです';
                break;
            case 408:
                $message = 'タイムアウトです';
                break;
            case 414:
                $message = 'リクエストURIが長すぎます';
                break;
            case 419:
                $message = '不正なリクエストです';
                break;
            case 500:
                $message = 'サーバーエラー';
                break;
            case 503:
                $message = 'Service Unavailable';
                break;
            default:
                $message = 'エラー';
                break;
        }
        //乱数発行

        $error_id = uniqid('error_', true);
        //ログ記入
        Log::error("Error ID:{$error_id} - URL: {$url} - Error {$status_code}: {$message}", ['request' => $request->all()]);
        
        //json形式でエラーの内容を共通エラーページに返す
        return response()->json([
            'error' => true,
            'error_id' => $error_id,
            'message' => $message,
            'status_code' => $status_code
        ]);
    
    }
    
}
