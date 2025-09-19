@extends('front.layouts.master')

@section('page_title', s_trans('Həkimlər').' - Doktor.az Klinika')

@section('main')

<div class="md:h-[85vh]">
    <div class="grid lg:grid-cols-1 xl:grid-cols-12 lg:grid-rows-12 xl:grid-rows-1 gap-3 md:h-full">

        <div class="col-span-12 lg:col-span-1 xl:col-span-5 lg:row-span-4 xl:row-span-1 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-1 xl:grid-rows-12 gap-3">
            <div class="tile service-intro flex-col items-start p-6 xl:row-span-5 min-h-48" style="--service-color: #1A6CE7;">
                <img src="{{ asset('front/img/bg_about.png') }}" alt="" class="tile-bg">
                <a href="{{ route('home') }}" class="btn btn-adaptive">
                    <i data-feather="chevron-left"></i>
                    {{ s_trans('Ana səhifə') }}
                </a>
                <div class="mt-auto">
                    <h2 class="text-3xl md:text-4xl font-semibold">{{ s_trans('Həkimlərimiz') }}</h2>
                    <div class="mt-2 opacity-75">{{ s_trans('Peşəkar heyətimizlə tanış olun') }}</div>
                </div>
            </div>
            <div class="tile block xl:row-span-7 pl-3 md:pl-6 pr-0 pt-0 pb-6">
                <div class="swiper doc-slider" id="doc_slider">
                    <div class="mt-5 mb-3 pl-3 md:pl-0">
                        <h2 class="text-xl font-semibold">{{ s_trans('Önə çıxan həkimlər') }}</h2>
                    </div>
                    <div class="swiper-wrapper">
                        @foreach ($featured_doctors as $k=>$doctor)
                        <div class="swiper-slide doctor">
                            <div class="doc-name text-sm"><b>{{ $doctor->first_name.' '.$doctor->last_name }}</b><br>{{ $translation[$doctor->designation] }}</div>
                            <img src="{{ media($doctor->photo) }}" alt="">
                            <a href="#" class="btn btn-waterdrop btn-doc-detail"><i data-feather="info"></i></a>
                        </div>
                        @endforeach
                    </div>
                    <!-- Arrows -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                    
                </div>
            </div>
        </div>
       
        <div class="col-span-12 lg:col-span-1 xl:col-span-7 lg:row-span-8 xl:row-span-1 tile flex-col min-h-96 has-read-more">
            
            <div class="overflow-x-scroll flex filter-bar items-stretch gap-2 pt-6 pb-3 px-6">
                @foreach ($services as $k=>$service)
                <a href="#" class="bg-slate-100 radius-x p-3 @if($k==0) active @endif">{{ $translations[$service->name] }}</a>
                @endforeach
            </div>
            <div class="overflow-y-scroll pb-32`">
                <div class="p-3 md:p-6 pt-2 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
                    @foreach ($doctors as $k=>$doctor)
                    <div class="doctor">
                        <div class="doc-name text-sm"><b>{{ $doctor->first_name.' '.$doctor->last_name }}</b><br>{{ $translation[$doctor->designation] }}</div>
                        <img src="{{ media($doctor->photo) }}" alt="">
                        <a href="#" class="btn btn-waterdrop btn-doc-detail"><i data-feather="info"></i></a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
