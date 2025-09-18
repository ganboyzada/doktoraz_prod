@extends('front.layouts.master')

@section('page_title', s_trans('Xidmətlər').' - Doktor.az Klinika')

@section('main')

    {{-- @isset($dep)
        @include('front.includes.breadcrumb', [
            'title' => s_trans('Xidmətlər'),
            'sublinks' => [
                    route('department.services', $dep->slug) => translate($dep->name)
                ]
            ])
    @else
        @include('front.includes.breadcrumb', ['title'=>s_trans('Xidmətlər')])
    @endisset --}}

<div class="md:h-[85vh] flex gap-3 departments">
    <div class="department services-clinical" data-id='1' style="--dep-color: #1a6ce7;">
        <div class="dep-title flex items-center mb-4">
            <img src="{{ asset('front/img/dep1.png') }}" class="dep-bg" alt="">
            <button type="button" class="back-to-categs mr-4 btn no-text btn-waterdrop w-[45px] h-[45px]"><i width="35" height="35" data-feather="chevron-left"></i></button>
            <h2 class="font-semibold">Poliklinik xidmətlər</h2>
            <button type="button" class="browse-categ mr-4 btn btn-adaptive">
                Xidmətlərə bax
                <i width="35" height="35" data-feather="chevron-right"></i></button>
        </div>
        
        <div class="service-tiles grid grid-cols-2 md:grid-cols-4 auto-rows-[120px] gap-2 md:h-[90%]">
            @foreach (['Terapiya','Kardiologiya','Pediatriya','Urologiya','Nevropatologiya',
                        'Ginekologiya','Dermatologiya','Qastroenterologiya','Endokrinologiya',
                        'Travmatologiya','Kosmetologiya','Fizioterapiya'] as $service)
            <a href="{{ route('services.find', 'terapiya') }}" class="tile tile-service">
                <img src="{{ asset('front/img/bg_about.png') }}" class="service-cover" alt="">
                <div class="tile-title">
                    {{ $service }} 
                </div>
            </a>   
            @endforeach
        </div>
    </div>
    <div class="department services-surgical" data-id='2' style="--dep-color: #0ab470;">
        <div class="dep-title flex items-center mb-4">
            <img src="{{ asset('front/img/dep2.png') }}" class="dep-bg" alt="">
            <button type="button" class="back-to-categs mr-4 btn no-text btn-waterdrop w-[45px] h-[45px]"><i width="35" height="35" data-feather="chevron-left"></i></button>
            <h2 class="font-semibold">Cərrahiyyə</h2>
            <button type="button" class="browse-categ mr-4 btn btn-adaptive">
                Xidmətlərə bax
                <i width="35" height="35" data-feather="chevron-right"></i></button>
        </div>
        <div class="service-tiles grid grid-cols-2 md:grid-cols-4 auto-rows-[120px] gap-2 md:h-[90%]">
            @foreach (['Ümumi cərrahiyyə','Plastik cərrahiyyə','LOR Cərrahiyyə',
                        'Neyrocərrahiyyə','Travmatoloji cərrahi', 'Uroloji cərrahiyyə'] as $service)
            <a href="{{ route('services.find', 'terapiya') }}" class="tile tile-service">
                <img src="{{ asset('front/img/bg_about.png') }}" class="service-cover" alt="">
                <div class="tile-title">
                    {{ $service }}
                </div>
            </a>
            @endforeach
        </div>
    </div>
    <div class="department services-diagnostic" data-id='3' style="--dep-color: #597196;">
        <div class="flex items-center mb-4">
            <img src="{{ asset('front/img/dep3.png') }}" class="dep-bg" alt="">
            <button type="button" class="back-to-categs mr-4 btn no-text btn-waterdrop w-[45px] h-[45px]"><i width="35" height="35" data-feather="chevron-left"></i></button>
            <h2 class="font-semibold">Diaqnostika</h2>
            <button type="button" class="browse-categ mr-4 btn btn-adaptive">
                Xidmətlərə bax
                <i width="35" height="35" data-feather="chevron-right"></i></button>
        </div>

        <div class="service-tiles grid grid-cols-2 md:grid-cols-4 auto-rows-[120px] gap-2 md:h-[90%]">
            @foreach (['Laboratoriya','Rentgenologiya','Kompüter Tomoqrafiya (KT)'] as $service)
            <a href="{{ route('services.find', 'terapiya') }}" class="tile tile-service">
                <img src="{{ asset('front/img/bg_about.png') }}" class="service-cover" alt="">
                <div class="tile-title">
                    {{ $service }}
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>



@endsection