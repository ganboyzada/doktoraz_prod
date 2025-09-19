<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="{{ asset('inno/css/bootstrap.min.css') }}" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/scss/admin.scss','resources/js/admin.js'])
    </head>
    <body>
        <div class="vh-100 d-flex flex-column justify-content-center align-items-center bg-light">
            
            <div class="bg-white rounded p-4 shadow overflow-hidden" style="width: 400px; max-width: 90vw;"">
                <div class="w-100 inno-logo">
                    <a href="/">
                        <x-application-logo height="40" />
                    </a>
                    <span class="powered-by">Powered by <img class="ms-1 h-28" src="{{ asset('inno/img/logo_dark.svg') }}" alt="innopanel_logo" ></span>
                </div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
