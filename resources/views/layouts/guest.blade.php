<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @viteReactRefresh
        @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    </head>
    <body class="vh-100 row justify-content-center align-items-center flex-column">
        <div class="shadow-lg p-md-5 col-lg-4 col-md-8 col-sm-10 col-11 d-flex justify-content-center align-items-center flex-column">
            <div class="d-flex justify-content-center my-4">
                <a href="/">
                    <x-application-logo/>
                </a>
            </div>

            <div class="w-100">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
