<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WeatherService;
use Symfony\Component\HttpFoundation\JsonResponse;

class WeatherController extends Controller
{
    public function __construct(
        protected WeatherService $service
    ) {
    }

    public function get(): JsonResponse
    {
        $data = $this->service->get();

        return $this->json($data);
    }
}
