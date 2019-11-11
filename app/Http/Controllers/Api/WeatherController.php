<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Api\ValidationException;
use App\Http\Controllers\Controller;
use App\Services\WeatherService;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\JsonResponse;

use function api_response;

class WeatherController extends Controller
{
    private $service;

    public function __construct(WeatherService $service)
    {
        $this->service = $service;
    }

    /**
     * @throws ValidationException
     *
     * @return JsonResponse
     */
    public function get()
    {
        try {
            $data = $this->service->get();

            return api_response($data);
        }
        catch (ClientException $exception) {
            $content = $exception->getResponse()->getBody()->getContents();
            $decoded = json_decode($content);
            $message = $decoded->message ?? $exception->getMessage();

            return api_response($message, $exception->getCode());
        }
    }
}
