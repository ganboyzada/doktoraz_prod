<!DOCTYPE html>
@php
	$basket = session()->get('basket', []);
@endphp
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('page_title', 'Doktor.az Klinika')</title>

    <meta name="description" content="@yield('meta_desc', '')">
    <meta name="keywords" content="@yield('meta_tags', '')">
    <meta name="author" content="Doktor.az Klinika">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('front/apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('front/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('front/favicon-16x16.png') }}">
	<link rel="manifest" href="{{ asset('front/site.webmanifest') }}">

    @vite(['resources/scss/app.scss','resources/js/app.js'])

    @stack('css')
</head>
<body class="sm:h-screen sm:max-h-screen py-7 px-1 sm:px-5 xl:px-16 antialiased">
    @include('front.layouts.header')

    @yield('main')

    @include('front.layouts.footer')

    @stack('js')
</body>
</html>