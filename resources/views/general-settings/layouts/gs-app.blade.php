<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('vendor/general-settings/css/gs-styles.css') }}">

    @yield('styles')
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4">
        @yield('content')
    </div>

    <!-- Scripts -->
    @yield('scripts')
</body>
</html>
