<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4">
        @yield('content')
    </div>

    <!-- Scripts -->
    @stack('scripts')
</body>
</html>
