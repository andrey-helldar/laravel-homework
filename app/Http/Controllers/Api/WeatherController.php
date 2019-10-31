<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WeatherService;

use function api_response;

class WeatherController extends Controller
{
    private $service;

    public function __construct(WeatherService $service)
    {
        $this->service = $service;
    }

    public function get()
    {
        $data = $this->service->get();

        return api_response($data);
    }
}
