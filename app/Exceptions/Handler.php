<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response|Response|ApiExceptionResponse
     */
    public function render($request, Exception $exception)
    {
        if ($request->is('api/*'))
        {
//            return $this->handleApiException( $request, $exception );
            return new ApiExceptionResponse( $exception );
        }
        else
        {
            return parent::render( $request, $exception );
        }
    }

    /**
     * HttpExeceptionの場合に、アプリケーション独自のエラー画面を表示する
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpException $e
     * @return \Illuminate\Http\Response
     */
    protected function renderHttpException(HttpException $e)
    {
        $status_code = $e->getStatusCode();

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
                $message = 'ページが見つかりませんでした。お探しのコンテンツは既に削除された場合があります。';
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
                $message = 'エラー';
                break;
        }

        //共通テンプレートを使用
        return response()->view("errors.common",
            [
                // VIEWに与える変数
                'exception'   => $e,
                'message'     => $message,
                'status_code' => $status_code,
            ],
            $status_code, // レスポンス自体のステータスコード
            $e->getHeaders()
        );
    }

    /**
     * HTTPException以外の例外をHttpExceptionに変換する
     *
     * @param Request $request
     * @param Exception $e
     * @return Response
     */
    protected function prepareResponse($request, Exception $e)
    {
        // デバッグ以外の環境で、HTTPじゃない例外が起これば、HTTP例外の500に変更する
        if ( !$this->isHttpException($e) && !config('app.debug')) {
            $e = new HttpException(500, $e->getMessage(), $e);
        }

        return parent::prepareResponse($request, $e);
    }

    /**
     * API例外処理
     *
     * @param $request
     * @param Exception $exception
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleApiException( $request, Exception $exception )
    {
        // Laravel Passportの認証エラーを変換
        if ( $exception instanceof AuthenticationException )
        {
            $exception = new HttpException(401 );
        }

        return $this->customApiResponse( $exception );
    }

    /**
     * エラーレスポンス生成
     *
     * @param \Exception $exception
     * @return \Illuminate\Http\JsonResponse
     */
    private function customApiResponse( $exception )
    {
        if ( $exception instanceof HttpException )
        {
            $statusCode = $exception->getStatusCode();
        }
        else
        {
            $statusCode = 500;
        }

        $response = [];

        switch ( $statusCode ) {
            case 400:
                $response['message'] = 'Bad Request';
                break;
            case 401:
                $response['message'] = 'Unauthorized';
                break;
            case 403:
                $response['message'] = 'Forbidden';
                break;
            case 404:
                $response['message'] = 'Not Found';
                break;
            case 405:
                $response['message'] = 'Method Not Allowed';
                break;
            default:
                $response['message'] = 'Internal Server Error';
                break;
        }
        $response['code'] = $statusCode;

        if ( config('app.debug') ) {
            $response['trace'] = $exception->getTrace();
        }

        return response()->json([
            'status' => 'error',
            'result' =>  $response
        ], $statusCode);
    }
}
