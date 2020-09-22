<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiExceptionResponse implements Responsable
{
    private const ERROR_MESSAGES = [
        400 => 'Bad Request',
        401 => 'UnAuthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        500 => 'Internal Serve Error'
     ];

    private $exception;
    private $statusCode;
    private $customErrorMessage;
    private $customErrors;

    public function __construct( \Exception $exception )
    {
        $this->exception = $exception;
    }

    /**
     * @inheritDoc
     */
    public function toResponse($request)
    {
        $this->prepareResponse();
        $this->setStatusCode();

        return response()->json([
            'status' => 'error',
            'result' => $this->_ToOutput()
        ],$this->statusCode);
    }

    private function _ToOutput(): array
    {
        $ret = [];

        $ret['message'] = self::ERROR_MESSAGES[$this->statusCode];
        $ret['status'] = $this->statusCode;

        if ( $this->customErrorMessage ) {
            $ret['message'] = $this->customErrorMessage;
        }

        if ( $this->customErrors ) {
            $ret['errors'] = $this->customErrors;
        }

        if ( config('app.debug') ) {
            $ret['trace'] = $this->exception->getTraceAsString();
        }

        return $ret;
     }

    /**
     * 各種例外を変換する
     */
    private function prepareResponse()
    {
        if ( $this->exception instanceof AuthenticationException )
        {
            $this->exception = new HttpException(401 );
        }

        if ( $this->exception instanceof ValidationException )
        {
            $this->customErrorMessage = $this->exception->getMessage();
            $this->customErrors = $this->exception->errors();
            $this->exception = new HttpException(400 );
        }
    }

    /**
     * ステータスコードを設定
     */
    private function setStatusCode()
    {
        if ( $this->exception instanceof HttpException )
        {
            $this->statusCode = $this->exception->getStatusCode();
        }
        else
        {
            $this->statusCode = 500;
        }
    }
}
