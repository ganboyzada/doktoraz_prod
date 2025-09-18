@extends('front.layouts.master')

@section('page_title', s_trans('Xidmətlər').' - Doktor.az Klinika')

@section('main')

<div class="md:h-[85vh]">
    <div class="grid lg:grid-cols-12 lg:grid-rows-1 gap-3 h-full">
        <div class="col-span-12 md:col-span-6 lg:col-span-6 xl:col-span-5 2xl:col-span-4 grid grid-cols-1 lg:grid-rows-12 gap-3">
            <div class="tile service-intro flex-col items-start p-6 row-span-5 2xl:row-span-6" style="--service-color: #FF6B65;">
                <img src="{{ asset('front/img/cardio_bg.jpg') }}" alt="" class="tile-bg">
                <a href="{{ route('services') }}" class="btn btn-adaptive">
                    <i data-feather="chevron-left"></i>
                    Bütün şöbələr
                </a>
                <div class="mt-auto">
                    <h2 class="mt-6 md:mt-0 text-3xl xl:text-4xl font-semibold">Kardiologiya</h2>
                    <div class="mt-2 lg:mt-3 opacity-75">Ürək və qan dövranı müayinələri</div>
                </div>
            </div>
            <div class="tile block row-span-7 2xl:row-span-6 pl-3 md:pl-6 pr-0 pt-0 pb-6">
                
                <div class="swiper doc-slider" id="doc_slider">
                    <div class="mt-5 mb-3 pl-3 md:pl-0">
                        <h2 class="text-xl font-semibold">Sahə üzrə həkimlər</h2>
                    </div>
                    <div class="swiper-wrapper">
                        @foreach (['Dr Etiram Musayev', 'Dr Xumar Muradova', 'Dr Əli Zamanov'] as $k=>$slide)
                        <div class="swiper-slide doctor">
                            <div class="doc-name text-sm"><b>{{ $slide }}</b><br>Kardioloq</div>
                            <img src="{{ asset('front/img/fg_docs_'. $k+1 .'.png') }}" alt="">
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
        <div class="col-span-12 md:col-span-6 lg:col-span-6 xl:col-span-4 grid grid-cols-1 lg:grid-rows-12 gap-3">
            <div class="tile has-read-more flex-col row-span-8 2xl:row-span-8 p-6 pb-0">
                <div class="flex items-center mb-3">
                    <i width="30" height="30" class="mr-3" data-feather="info" ></i>
                    <h2 class="text-xl font-semibold">Ümumi Məlumat</h2>
                </div>

                <div class="overflow-y-scroll h-full min-h-72">
                    <div class="h-[100px] leading-7">
                        <div class="pb-[150px]">Kardiologiya – ürək və qan dövranı sistemi xəstəliklərinin diaqnostikası, müalicəsi və profilaktikası ilə məşğul olan mühüm tibbi sahədir. Bu xidmət çərçivəsində pasiyentlər ürək ritminin pozulmaları, təzyiq problemləri, damar xəstəlikləri, ürək çatışmazlığı və digər kardioloji narahatlıqlar üzrə peşəkar həkimlər tərəfindən müayinə və müalicə alır. Klinikamız müasir avadanlıqlarla təchiz olunmuşdur və EKQ, Exokardioqrafiya, Exo, Stres testi kimi müayinələr vasitəsilə dəqiq nəticələr təqdim edir. Məqsədimiz pasiyentlərə vaxtında diaqnoz qoymaq, effektiv müalicə planı qurmaq və sağlam həyat keyfiyyətini təmin etməkdir.
                        </div>
                    </div>
                </div>

            </div>
            <div class="tile flex-col row-span-4 2xl:row-span-4 p-6">
                <div class="">
                    <h2 class="text-xl font-semibold">Çağrı Mərkəzi</h2>
                    <div class="mt-2 opacity-75">Qəbula yazılmaq üçün əlaqə saxlayın</div>
                </div>
                <div class="flex flex-wrap pt-3 mt-auto gap-2">
                    <a href="tel:0555247839" class="btn btn-green"><i data-feather="phone" stroke-width="2"></i><span class="hidden lg:inline">055 524 78 39</span></a>
                    <a href="tel:0706609355" class="btn btn-green"><i data-feather="phone" stroke-width="2"></i></a>
                    <a href="#" class="btn btn-waterdrop"><i data-feather="message-circle"></i>Whatsapp</a>
                </div>
            </div>
        </div>    
        <div class="col-span-12 lg:col-span-12 xl:col-span-3 2xl:col-span-4 tile flex-col py-6 has-read-more">
            <div class="mb-4 px-6">
                <div class="mb-1 opacity-75">Poliklinik Xidmətlər</div>
                <h2 class="text-xl font-semibold">Digər sahələr</h2>
            </div>
            <div class="service-tiles grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-1 2xl:grid-cols-2 auto-rows-[40px] md:auto-rows-[60px] gap-3 overflow-y-scroll pb-32 px-6">
                @foreach (['Terapiya','Kardiologiya','Pediatriya','Urologiya','Nevropatologiya',
                            'Ginekologiya','Dermatologiya','Qastroenterologiya','Endokrinologiya',
                            'Travmatologiya','Kosmetologiya','Fizioterapiya'] as $service)
                <a href="{{ route('services.find', 'terapiya') }}" class="tile tile-service related-service">
                    
                    <div class="tile-title">
                        {{ $service }} 
                    </div>
                </a>   
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
