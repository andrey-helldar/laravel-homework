<?php

return [

    'supportsCredentials' => false,

    'allowedOrigins' => [
        parse_url(env('APP_URL', 'http://localhost'), PHP_URL_HOST),
    ],

    'allowedOriginsPatterns' => [],

    'allowedHeaders' => ['*'],

    'allowedMethods' => ['GET', 'POST', 'PUT', 'DELETE'],

    'exposedHeaders' => [],

    'maxAge' => 0,

];
