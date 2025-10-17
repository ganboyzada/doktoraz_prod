@extends('front.layouts.master')

@section('page_title', s_trans('Həkimlər').' - Doktor.az Klinika')

@section('main')

<div class="md:h-[80vh]">
    <div class="grid grid-cols-1 xl:grid-cols-12 md:grid-rows-12 xl:grid-rows-1 gap-3 md:h-full">

        <div class="xl:col-span-4 md:row-span-4 lg:row-span-4 xl:row-span-1 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-1 xl:grid-rows-12 gap-3">
            <div class="tile service-intro flex-col items-start p-6 xl:row-span-5 2xl:row-span-6 min-h-48" style="--service-color: #1A6CE7;">
                <img src="{{ asset('front/img/bg_about.webp') }}" alt="" class="tile-bg">
                <a href="{{ loc_route('home') }}" class="btn btn-adaptive">
                    <i data-feather="chevron-left"></i>
                    {{ s_trans('Ana səhifə') }}
                </a>
                <div class="mt-auto">
                    <h2 class="text-3xl md:text-4xl font-semibold">{{ s_trans('hekimler-basliq') }}</h2>
                    <div class="mt-2 opacity-75">{{ s_trans('hekimler-alt-basliq') }}</div>
                </div>
            </div>
            <div class="tile block xl:row-span-7 2xl:row-span-6 pl-3 md:pl-6 pr-0 pt-0 pb-6">
                <div class="swiper doc-slider" id="doc_slider">
                    <div class="mt-5 mb-3 pl-3 md:pl-0">
                        <h2 class="text-xl font-semibold">{{ s_trans('secilmis-hekimler') }}</h2>
                    </div>
                    <div class="swiper-wrapper">
                        @foreach ($featured_doctors as $k=>$doctor)
                        <div class="swiper-slide doctor text-sm !h-full">
                            <div class="doc-name text-sm mb-1"><b>{{ $doctor->first_name.' '.$doctor->last_name }}</b></div>
                            <div>{{ translate($doctor->designation) }}</div>
                            <img src="{{ media($doctor->photo) }}" alt="">
                            <a href="{{ loc_route('doctors.find', $doctor->slug) }}" class="btn btn-waterdrop btn-doc-detail"><i data-feather="info"></i></a>
                        </div>
                        @endforeach
                    </div>
                    <!-- Arrows -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                    
                </div>
            </div>
        </div>
       
        <div class="lg:col-span-1 xl:col-span-8 md:row-span-8 lg:row-span-8 xl:row-span-1 tile flex-col min-h-96 has-read-more">
            
            <div class="overflow-x-scroll flex flex-nowrap gap-2 filter-bar pt-6 pb-3 px-6 min-h-16">
                <a href="{{ loc_route('doctors') }}" class="@if($active_service==null) active @endif btn btn-waterdrop font-medium px-3 py-3 min-h-8 max-h-8 text-sm">
                    <i data-feather="loader" stroke-width=2></i>
                </a>
                @foreach ($services as $k=>$service)
                <a href="{{ loc_route('doctors', ['service'=>$service->id]) }}" class="@if($service->id==$active_service) active @endif btn btn-waterdrop whitespace-nowrap font-medium px-3 py-4 min-h-8 max-h-8 text-sm">
                    {{ translate($service->name) }}</a>
                @endforeach
            </div>
            <div class="overflow-y-scroll pb-32">
                <div class="p-3 md:p-6 !pt-2 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-2">
                    @foreach ($doctors as $k=>$doctor)
                    <a href="{{ loc_route('doctors.find', $doctor->slug) }}" class="doctor text-sm">
                        <div class="doc-name mb-1"><b>{{ $doctor->first_name.' '.$doctor->last_name }}</b></div>
                        <div class="doc-designation">{{ translate($doctor->designation) }}</div>
                        <img src="{{ media($doctor->photo) }}" alt="">
                        <span class="btn btn-waterdrop btn-doc-detail"><i data-feather="info"></i></span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
