<!DOCTYPE html>
@php
	$basket = session()->get('basket', []);
@endphp
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="color-scheme" content="light dark">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('page_title', 'DOKTOR AZ KLİNİKASI – Sumqayıt | Terapiya, Ginekologiya, Kardiologiya')</title>

    <meta name="description" content="@yield('meta_desc', '')">
    <meta name="keywords" content="@yield('meta_tags', '')">
    <link rel="canonical" href="https://doktoraz.az/">

    <link rel="alternate" href="https://doktoraz.az/az" hreflang="az" />
    <link rel="alternate" href="https://doktoraz.az/ru/" hreflang="ru" />
    <link rel="alternate" href="https://doktoraz.az/az" hreflang="x-default" />

    <meta name="author" content="Doktor.az Klinika">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
	
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <link rel="stylesheet" href="{{ asset('front/css/preloader.css') }}">

    @vite(['resources/scss/app.scss','resources/js/app.js'])

    @stack('css')
</head>
<body class="sm:h-screen sm:max-h-screen py-7 px-1 sm:px-5 xl:px-10 2xl:px-16 antialiased">
    
    @include('front.includes.preloader')

    @include('front.layouts.header')

    @yield('main')

    @include('front.layouts.footer')

    @stack('js')

    <script src="{{ asset('front/js/preloader.js') }}"></script>

</body>
</html>