<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

use function config;
use function http_build_query;
use function json_decode;

class WeatherService
{
    private $client;

    private $url = 'https://api.weather.yandex.ru/v1/forecast';

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get()
    {
        $ttl = config('weather.cache_ttl', 5);

        return Cache::remember('weather', $ttl, function () {
            return $this->load();
        });
    }

    private function load()
    {
        $response = $this->client->get($this->buildUrl(), ['verify' => false]);
        $content  = $response->getBody()->getContents();

        return json_decode($content);
    }

    private function buildUrl(): string
    {
        $url = Str::finish($this->url, '?');

        return $url . $this->buildQuery();
    }

    private function buildQuery(): string
    {
        $params = [
            'lat'   => config('latitude'),
            'lon'   => config('longitude'),
            'lang'  => config('weather.lang', 'ru_RU'),
            'limit' => config('weather.limit', 7),
            'hours' => config('weather.hours', true),
            'extra' => config('weather.extra', false),
        ];

        return http_build_query($params);
    }
}
