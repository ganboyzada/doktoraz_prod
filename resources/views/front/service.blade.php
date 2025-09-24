@extends('front.layouts.master')

@section('page_title', $translations[$service->name].' - Doktor.az Klinika')

@section('main')

<div class="md:h-[85vh]">
    <div class="grid lg:grid-cols-12 lg:grid-rows-1 gap-3 h-full">
        <div class="col-span-12 md:col-span-6 lg:col-span-6 xl:col-span-5 2xl:col-span-4 grid grid-cols-1 lg:grid-rows-12 gap-2 sm:gap-3">
            <div class="tile service-intro flex-col items-start p-6 row-span-5 2xl:row-span-6" style="--service-color: {{ $service->color ? $service->color : '#3D4871' }};">
                @php
                    $cover_photo = $service->photo ? $service->photo : $service->department->photo;
                @endphp
                @if($cover_photo)
                <img src="{{ media($cover_photo) }}" alt="service_bg" class="tile-bg">
                @endif
                <a href="{{ route('services') }}" class="btn btn-adaptive">
                    <i data-feather="chevron-left"></i>
                    {{ s_trans('Bütün şöbələr') }}
                </a>
                <div class="mt-auto">
                    <h2 class="mt-6 md:mt-0 text-3xl xl:text-4xl font-semibold">{{ $translations[$service->name] }}</h2>
                    <div class="mt-2 lg:mt-3 opacity-75">Ürək və qan dövranı müayinələri</div>
                </div>
            </div>
            <div class="tile block row-span-7 2xl:row-span-6 pl-3 md:pl-6 pr-0 pt-0 pb-6">
                @if(count($service->members))
                <div class="swiper doc-slider" id="doc_slider">
                    <div class="mt-5 mb-3 pl-3 md:pl-0">
                        <h2 class="text-xl font-semibold">{{ s_trans('Sahə üzrə həkimlər') }}</h2>
                    </div>
                    <div class="swiper-wrapper">
                        @foreach ($service->members as $k=>$doctor)
                        <a class="swiper-slide doctor" href="{{ route('doctors.find', $doctor->slug) }}">
                            <div class="doc-name text-sm"><b>{{ $doctor->first_name.' '.$doctor->last_name }}</b><br>{{ $translations[$doctor->designation] }}</div>
                            <img src="{{ media($doctor->photo) }}" alt="">
                            <span class="btn btn-waterdrop btn-doc-detail"><i data-feather="info"></i></span>
                        </a>
                        @endforeach
                        
                    </div>
                    <!-- Arrows -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                    
                </div>
                @endif
            </div>
        </div>
        <div class="col-span-12 md:col-span-6 lg:col-span-6 xl:col-span-4 grid grid-cols-1 lg:grid-rows-12 gap-2 sm:gap-3">
            <div class="tile has-read-more flex-col row-span-8 2xl:row-span-8 p-6 pb-0">
                <div class="flex items-center mb-3">
                    <i width="30" height="30" class="mr-3" data-feather="info" ></i>
                    <h2 class="text-xl font-semibold">{{ s_trans('Ümumi Məlumat') }}</h2>
                </div>

                <div class="overflow-y-scroll h-full min-h-72">
                    <div class="h-[100px] leading-7">
                        <div class="pb-[150px]">
                            {!! $translations[$service->desc] !!}
                        </div>
                    </div>
                </div>

            </div>
            <div class="tile flex-col row-span-4 2xl:row-span-4 p-6">
                <div class="">
                    <h2 class="text-xl font-semibold">{{ s_trans('Çağrı Mərkəzi') }}</h2>
                    <div class="mt-2 opacity-75">{{ s_trans('Qəbula yazılmaq üçün əlaqə saxlayın') }}</div>
                </div>
                <div class="flex flex-wrap pt-3 mt-auto gap-2">
                    <a href="tel:0555247839" class="btn btn-green"><i data-feather="phone" stroke-width="2"></i><span class="hidden lg:inline">055 524 78 39</span></a>
                    <a href="tel:0706609355" class="btn btn-green"><i data-feather="phone" stroke-width="2"></i></a>
                    <a href="#" class="btn btn-waterdrop"><i data-feather="message-circle"></i>{{ s_trans('Whatsapp') }}</a>
                </div>
            </div>
        </div>    
        <div class="col-span-12 lg:col-span-12 xl:col-span-3 2xl:col-span-4 tile flex-col py-6 has-read-more">
            <div class="mb-4 px-6">
                <div class="mb-1 opacity-75">{{ $translations[$service->department->name] }}</div>
                <h2 class="text-xl font-semibold">{{ s_trans('Digər sahələr') }}</h2>
            </div>
            <div class="service-tiles grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-1 2xl:grid-cols-2 gap-3 overflow-y-scroll pb-32 px-6">
                @foreach ($related_services as $rel_service)
                <a href="{{ route('services.find', $rel_service->slug) }}" class="tile tile-service related-service">
                    @if($rel_service->icon)
                    <img src="{{ media($rel_service->icon) }}" alt="serv_id_{{ $rel_service->id }}_icon">
                    @endif
                    <div class="tile-title">
                        
                        {{ $translations[$rel_service->name] }} 
                    </div>
                </a>   
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
