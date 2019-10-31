<?php

namespace App\Services;

use App\Validators\WeatherValidator;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

use function config;
use function http_build_query;
use function json_decode;

class WeatherService
{
    private $client;

    private $validator;

    public function __construct(Client $client, WeatherValidator $validator)
    {
        $this->client    = $client;
        $this->validator = $validator;
    }

    /**
     * @throws \App\Exceptions\Api\ValidationException
     *
     * @return object
     */
    public function get()
    {
        $response = $this->client->get($this->buildUrl(), ['verify' => false]);
        $content  = $response->getBody()->getContents();

        return json_decode($content);
    }

    /**
     * @throws \App\Exceptions\Api\ValidationException
     *
     * @return string
     */
    private function buildUrl(): string
    {
        $url = config('weather.api_url');
        $url = Str::finish($url, '?');

        return $url . $this->buildQuery();
    }

    /**
     * @throws \App\Exceptions\Api\ValidationException
     *
     * @return string
     */
    private function buildQuery(): string
    {
        $params = [
            'lat'   => $this->getLatitude(),
            'lon'   => $this->getLongitude(),
            'lang'  => $this->getLanguage(),
            'limit' => $this->getLimit(),
            'hours' => $this->getHours(),
            'extra' => $this->getExtra(),
        ];

        $this->validator->check($params);

        return http_build_query($params);
    }

    private function getLatitude(): float
    {
        return (float) config('latitude');
    }

    private function getLongitude(): float
    {
        return (float) config('longitude');
    }

    private function getLanguage(): string
    {
        return config('weather.lang', 'ru_RU');
    }

    private function getLimit(): int
    {
        $value = (int) config('weather.limit', 7);

        return $value >= 1 ? $value : 1;
    }

    private function getHours(): bool
    {
        return (bool) config('weather.hours', true);
    }

    private function getExtra(): bool
    {
        return (bool) config('weather.extra', false);
    }
}
