@extends('front.layouts.master')

@push('css')

@endpush

@section('main')

<div class="grid sm:grid-cols-2 xl:grid-cols-3 sm:grid-rows-3 lg:grid-rows-12 xl:grid-rows-1 gap-3 md:h-[85vh]">
    <!-- Large tile -->
    <div class="tile sm:row-span-2 lg:row-span-8 xl:row-span-1">
        <div class="swiper" id="home_slider">
            <div class="swiper-wrapper">
                @php
                    $slides = [
                        'Pediatrik Checkup paketimiz yenidən qüvvədə' => 'slide_2.png',
                        'Laborator nəticələrini QR kod ilə əldə et' => 'slide_1.png',
                    ]
                @endphp
                @foreach ($slides as $caption=>$img)
                <div class="swiper-slide">
                    <img src="{{ asset('front/img/'.$img) }}" alt="">
                    <div class="slide-overlay">
                        <div class="welcome-msg"><img src="{{ asset('front/img/logo_icon.svg') }}" alt="doktoraz_logo_ico">Hər vaxtınız xeyir olsun</div>
                        <div class="slide-caption w-[80%] md:w-[70%]">
                         {{ $caption }}
                        </div>
                    </div>
                </div>
                @endforeach
                
            </div>
            <!-- Arrows -->
            <div class="swiper-button-prev btn-adaptive"></div>
            <div class="swiper-button-next btn-adaptive"></div>
            <!-- Dots -->
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <div class="sm:row-span-2 lg:row-span-8 xl:row-span-1 grid sm:grid-rows-12 gap-3">
        <div class="tile services row-span-5 md:row-span-7">
            <img src="{{ asset('front/img/bg_services.png') }}" class="bg-services" alt="">
            <div class="tile-title vert w-[40%]">
                <div>
                    <h2 class="t-heading">Xidmətlər</h2>
                    <div class="t-subheading">& şöbələr</div>
                </div>
                <a href="{{ route('services') }}" class="mt-auto btn btn-over-dark btn-adaptive w-[70px] h-[45px]"><i width="25" height="25" stroke-width=1.5 data-feather="grid"></i></a>
            </div>
        </div>
        <div class="tile doctors row-span-5">
            <div class="tile-title vert w-[40%]">
                <div>
                    <h2 class="t-heading">Həkimlər</h2>
                    <div class="t-subheading">Peşəkar komandamız</div>
                </div>
                <a href="{{ route('doctors') }}" class="mt-auto btn btn-over-dark btn-adaptive w-[70px] h-[45px]"><i width="25" height="25" stroke-width=1.5 data-feather="users"></i></a>
            </div>
            <img src="{{ asset('front/img/fg_docs_1.png') }}" class="fg-doc" alt="">
            <img src="{{ asset('front/img/fg_docs_2.png') }}" class="fg-doc" alt="">
        </div>
    </div>
    <!-- Medium tiles -->
  
    <div class="sm:col-span-2 lg:col-span-2 xl:col-span-1 lg:row-span-4 xl:row-span-1 grid sm:grid-cols-12 lg:grid-cols-3 xl:grid-cols-1 xl:grid-rows-12 gap-3">
        <div class="tile lg:row-span-2 sm:col-span-3 xl:col-span-1">
            <div class="tile-title xl:!py-1 w-full">
                <div>
                    <h2 class="t-heading">Haqqımızda</h2>
                    <div class="t-subheading">Fəaliyyət tarixçəmiz</div>
                </div>
                <a href="{{ route('about_us') }}" class="lg:ml-auto btn no-text btn-waterdrop w-[45px] h-[45px]"><i width="35" height="35" data-feather="chevron-right"></i></a>
            </div>
            
        </div>
        <div class="tile flex-col lg:row-span-10 xl:row-span-6 sm:col-span-5 lg:col-span-2 xl:col-span-1">
            <div class="tile-title vert relative">
                <h2 class="t-heading">Əlaqə & Ünvan</h2>
            </div>
            <ul class="contact-details px-[1.6rem]">
                <li id="mobile_numbers">
                    <i data-feather="smartphone"></i>
                    <a href="tel:0555247839">055 524 78 39</a> /
                    <a href="tel:0706609355">070 660 93 55</a>
                </li>
                <li id="city_numbers">
                    <i data-feather="phone"></i>
                    <a href="tel:0186458060">018 645 80 60</a> /
                    <a href="tel:0186445939">018 644 59 39</a>
                </li>
                <li id="location">
                    <i data-feather="map-pin"></i>
                    <a href="https://maps.app.goo.gl/pMisGExkSL8yZFq98">Sumqayıt ş., S.Bədəlbəyli 42H</a>
                </li>
                <li id="mail_addresses">
                    <i data-feather="mail"></i>
                    <a href="mailto:info@doktoraz.az">info@doktoraz.az</a>
                </li>
            </ul>
            <div class="flex mt-auto px-[1.6rem] pt-2 pb-[1.6rem] gap-3">
                <a href="tel:0555247839" class="btn btn-green px-3"><i data-feather="phone" stroke-width="2"></i><span class="hidden lg:inline">Zəng et</span></a>
                <a href="#" class="btn btn-waterdrop"><i data-feather="message-circle"></i>Whatsapp</a>
                <a href="mailto:info@doktoraz.az" class="btn btn-waterdrop"><i data-feather="mail"></i><span class="hidden xxl:inline">Sorğu yolla</span></a>
            </div>
        </div>
        <div class="tile flex-col lg:row-span-10 xl:row-span-4 sm:col-span-4 lg:col-span-1">

            <img src="{{ asset('front/img/ambulance.png') }}" class="tile-bg" alt="ambulance_image">
            <div class="tile-title vert relative">
                <h2 class="t-heading">Təcili yardım <br> <span class="font-light">Qaynar xətti</span></h2>
            </div>
            
            <div class="flex mt-auto px-[1.6rem] pb-[1.6rem] gap-3 relative">
                <a id="ambulance_numbers" href="tel:0186423333" class="btn px-3 btn-primary">
                    <i data-feather="phone" stroke-width=2></i><span class="hidden md:inline">018 642 33 33</span></a>
            </div>

            
        </div>
    </div>
  
</div>

@endsection