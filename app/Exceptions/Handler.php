<?php

namespace App\Exceptions;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use function api_response;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    protected function prepareJsonResponse($request, Exception $exception)
    {
        if ($exception instanceof ClientException) {
            $message = $this->getClientExceptionMessage($exception);
            $code    = $exception->getCode();
        }
        else {
            $message = $this->convertExceptionToArray($exception);
            $code    = $this->isHttpException($exception) ? $exception->getStatusCode() : 500;
        }

        return api_response($message, $code);
    }

    private function getClientExceptionMessage(ClientException $exception): string
    {
        $content = $exception->getResponse()->getBody()->getContents();
        $decoded = json_decode($content);
        $message = $decoded->message ?? $exception->getMessage();

        return $message;
    }
}
