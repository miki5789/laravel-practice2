<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }

        return parent::render($request, $e);
    }


    /*
     * 共通エラーページ
     
    protected function renderHttpException(\Symfony\Component\HttpKernel\Exception\HttpException $e)
    {
        $status = $e->getStatusCode();
        return response()->view("errors.common", ['exception' => $e], $status);
    }
    */


    function errorCheck(Request $request, Throwable $exception){
        //ログの中に詳細を仕込む
        //ログの詳細：
        //だれが　どの画面で　エラーの内容 どんなリクエスト　
        //ログID発行
        $status_code = $exception->getStatusCode();
        $message = $exception->getMessage();
    
        if (! $message) {
            switch ($status_code) {
                case 400:
                    $message = 'Bad Request';
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
                    $message = 'Internal Server Error';
                    break;
                case 503:
                    $message = 'Service Unavailable';
                    break;
                default:
                    $message = 'エラーが発生しました';
                    break;
            }
            //乱数発行
            $error_id = Str::random(8);
            // リクエストされたフルURL
            $url = $request->fullUrl(); 

            //ログ記入
            Log::error("Error ID:{$error_id} - URL: {$url} - Error {$status_code}: {$message}", ['request' => $request->all()]);
            
            //json形式でエラーの内容を共通エラーページに返す
            return response()->json([
                'error' => true,
                'error_id' => $error_id,
                'message' => $message
            ], $status_code);
        }
        }

}
