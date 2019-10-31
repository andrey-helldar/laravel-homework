<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name') }}</title>

    @include('layouts._meta')
    @include('layouts._links')
</head>
<body>

<div id="app"></div>

@include('layouts._scripts')
</body>
</html>
