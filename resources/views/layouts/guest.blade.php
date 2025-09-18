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

        <link href="{{ asset('inno/css/bootstrap.min.css') }}" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/sass/admin.scss','resources/js/admin.js'])
    </head>
    <body>
        <div class="vh-100 d-flex flex-column justify-content-center align-items-center bg-light">
            

            <div class="mt-6 bg-white shadow-md overflow-hidden">
                <div class="bg-dark w-100 py-3 px-4 inno-logo">
                    <a href="/">
                        <x-application-logo height="40" />
                    </a>
                </div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
