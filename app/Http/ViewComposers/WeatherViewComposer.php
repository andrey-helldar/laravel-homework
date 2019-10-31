<?php

namespace App\Http\ViewComposers;

use App\Contracts\ViewComposer;
use App\Services\WeatherService;
use Illuminate\View\View;

use function compact;

class WeatherViewComposer implements ViewComposer
{
    protected $service;

    public function __construct(WeatherService $service)
    {
        $this->service = $service;
    }

    public function compose(View $view)
    {
        $weather = $this->service->get();

        $view->with(compact('weather'));
    }
}
