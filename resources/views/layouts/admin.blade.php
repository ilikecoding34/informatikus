<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('Admin')) – {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="w-100" style="max-width: 420px;">
            <div class="text-center mb-4">
                <a href="{{ url('/') }}" class="text-dark text-decoration-none">
                    <span class="h4">{{ config('app.name') }}</span>
                </a>
                <p class="text-muted small mt-1">@yield('subtitle', __('Admin belépés'))</p>
            </div>
            @yield('content')
        </div>
    </div>
</body>
</html>
