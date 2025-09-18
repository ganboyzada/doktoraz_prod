<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {{ session('innotheme') ? 'data-bs-theme='.session('innotheme') : 'data-bs-theme=dark' }}>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('front/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('front/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('front/favicon-16x16.png') }}">

        <title>{{ 'Admin Panel - '.config('app.name') }}</title>

        <!-- Scripts -->
        <link href="{{ asset('inno/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('inno/css/bootstrap-icons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('inno/css/flag-icons.min.css') }}" rel="stylesheet">
        <script src="{{ asset('inno/js/jquery.js') }}"></script>
        <link href="{{ asset('inno/plugins/summernote-lite.css') }}" rel="stylesheet">
        <script src="{{ asset('inno/plugins/summernote-lite.js') }}"></script>
        <script src="{{ asset('inno/js/notify.min.js') }}"></script>

        @vite(['resources/scss/admin.scss','resources/js/admin.js'])
    </head>
    <body class="antialiased {{ session('innotheme') ? session('innotheme') : 'dark' }}-mode">
        <div class="min-h-screen">
            <x-inno::sidebar></x-inno::sidebar>

            <!-- Page Content -->
            <main>
                <x-inno::nav></x-inno::nav>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
