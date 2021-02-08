<?php

namespace App\Services;

use App\Constants\Weather;
use App\Validators\WeatherValidator;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class WeatherService extends BaseService
{
    public function __construct(
        protected Client $client,
        protected WeatherValidator $validator
    ) {
    }

    public function get()
    {
        return Http::withHeaders($this->headers())
            ->get($this->url(), $this->query())
            ->throw()
            ->json();
    }

    protected function url(): string
    {
        return config('weather.api_url');
    }

    protected function query(): array
    {
        $params = $this->parameters();

        $this->validator->check($params);

        return $params;
    }

    protected function headers(): array
    {
        return [
            'X-Yandex-API-Key' => config('weather.api_key'),
        ];
    }

    protected function parameters(): array
    {
        return [
            'lat'   => $this->getLatitude(),
            'lon'   => $this->getLongitude(),
            'lang'  => $this->getLanguage(),
            'limit' => $this->getLimit(),
            'hours' => $this->getHours(),
            'extra' => $this->getExtra(),
        ];
    }

    protected function getLatitude(): float
    {
        return (float) config('weather.latitude');
    }

    protected function getLongitude(): float
    {
        return (float) config('weather.longitude');
    }

    protected function getLanguage(): string
    {
        return config('weather.lang', Weather::DEFAULT_LANGUAGE);
    }

    protected function getLimit(): int
    {
        $value = (int) config('weather.limit', 7);

        return $value >= 1 ? $value : 1;
    }

    protected function getHours(): bool
    {
        return (bool) config('weather.hours', true);
    }

    protected function getExtra(): bool
    {
        return (bool) config('weather.extra', false);
    }
}
