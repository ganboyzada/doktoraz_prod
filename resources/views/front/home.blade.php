@extends('front.layouts.master')

@push('css')

@endpush

@section('main')

<div class="grid sm:grid-cols-2 xl:grid-cols-3 sm:grid-rows-3 lg:grid-rows-12 xl:grid-rows-1 gap-2 sm:gap-3 md:h-[85vh]">
    <!-- Large tile -->
    <div class="tile sm:row-span-2 lg:row-span-8 xl:row-span-1">
        <div class="swiper" id="home_slider">
            <div class="swiper-wrapper">
               
                @foreach ($slides as $slide)
                <div class="swiper-slide">
                    <img src="{{ media($slide->photo) }}" alt="">
                    <div class="slide-overlay">
                        <div class="welcome-msg"><img src="{{ asset('front/img/logo_icon.svg') }}" alt="doktoraz_logo_ico">{{ s_trans('ana-slayd-qarsilama') }}</div>
                        <div class="slide-caption w-[80%] md:w-[70%]">
                         {!! $translations[$slide->title] !!}
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

    <div class="sm:row-span-2 lg:row-span-8 xl:row-span-1 grid sm:grid-rows-12 gap-2 sm:gap-3">
        <div class="tile services row-span-5 md:row-span-7">
            <img src="{{ asset('front/img/bg_services.png') }}" class="bg-services" alt="">
            <div class="tile-title vert w-[40%]">
                <div>
                    <h2 class="t-heading">{!! s_trans('xidmetler-basliq', true) !!}</h2>
                    <div class="t-subheading">{!! s_trans('xidmetler-alt-basliq') !!}</div>
                </div>
                <a href="{{ route('services') }}" class="mt-auto btn btn-over-dark btn-adaptive w-[70px] h-[45px]">
                    <i width="25" height="25" stroke-width=1.5 data-feather="grid"></i></a>
            </div>
        </div>
        <div class="tile doctors row-span-5">
            <div class="tile-title vert w-[50%]">
                <div>
                    <h2 class="t-heading">{!! s_trans('hekimler-basliq', true) !!}</h2>
                    <div class="t-subheading">{!! s_trans('hekimler-alt-basliq') !!}</div>
                </div>
                <a href="{{ route('doctors') }}" class="mt-auto btn btn-over-dark btn-adaptive w-[70px] h-[45px]"><i width="25" height="25" stroke-width=1.5 data-feather="users"></i></a>
            </div>
            <img src="{{ asset('front/img/fg_docs_1.png') }}" class="fg-doc" alt="">
            <img src="{{ asset('front/img/fg_docs_2.png') }}" class="fg-doc" alt="">
        </div>
    </div>
  
    <div class="sm:col-span-2 lg:col-span-2 xl:col-span-1 
                lg:row-span-4 xl:row-span-1 
                grid sm:grid-cols-12 md:grid-cols-2 xl:grid-cols-1 
                md:grid-rows-3 xl:grid-rows-12 gap-2 sm:gap-3">

        <!-- HAQQIMIZDA -->
        <div class="tile xl:row-span-2 sm:col-span-3 md:col-span-1">
            <div class="tile-title md:!py-1 w-full">
                <div>
                    <h2 class="t-heading">{!! s_trans('haqqimizda-basliq', true) !!}</h2>
                    <div class="t-subheading">{!! s_trans('haqqimizda-alt-basliq') !!}</div>
                </div>
                <a href="{{ route('about_us') }}" class="lg:ml-auto btn no-text btn-waterdrop w-[45px] h-[45px]"><i width="35" height="35" data-feather="chevron-right"></i></a>
            </div>
        </div>

        <!-- ELAQE DETALLARI -->
        <div class="tile flex-col 
                    md:row-span-3 xl:row-span-6 
                    sm:col-span-5 md:col-span-1">
            <div class="tile-title vert relative">
                <h2 class="t-heading">{!! s_trans('elaqe-basliq', true) !!}</h2>
            </div>
            <div class="contact-details grid grid-cols-2 gap-2 px-[1.6rem]">
                <div id="mobile_numbers">
                    <div class="text-sm mb-2 opacity-75">{{ s_trans('Mobil xəttlər') }}</div>
                    <div class="flex flex-col gap-2">
                    @foreach(($s_details['mobile'] ?? []) as $mobile)
                    <a class="text-center flex items-center gap-2 border border-slate-300 radius-s py-2 px-3" 
                        href="tel:{{ str_replace(' ', '', $mobile['name']) }}">
                        <i data-feather="smartphone" width=20 height=20></i>
                        {{ $mobile['name'] }}</a>
                    @endforeach
                    </div>
                </div>
                <div id="city_numbers" class="mb-2">
                    <div class="text-sm mb-2 opacity-75">{{ s_trans('Şəhər xəttləri') }}</div>
                    <div class="flex flex-col gap-2">
                    @foreach(($s_details['phone'] ?? []) as $phone)
                    <a class="text-center flex items-center gap-2 border border-slate-300 radius-s py-2 px-3" 
                        href="tel:{{ str_replace(' ', '', $phone['name']) }}">
                        <i data-feather="phone" width=20 height=20></i>
                        {{ $phone['name'] }}</a>
                    @endforeach
                    </div>
                </div>
                @foreach(($s_details['address'] ?? []) as $address)
                <a href="{{ $address['link'] }}" class="col-span-2 flex items-center gap-2 border border-slate-300 radius-s px-3 py-2 text-sm">
                    <i height=20 data-feather="map-pin"></i>
                    {!! translate($address['value']) !!}
                </a>  
                @endforeach

            </div>
            <div class="flex mt-auto px-[1.6rem] pt-3 pb-[1.6rem] gap-2">
                
                <a href="tel:{{ str_replace(' ', '', $s_details['mobile'][0]['name']) }}" 
                    class="btn btn-adaptive px-4" style="background-color: #83E100 !important;">
                    <i data-feather="smartphone" stroke-width="2"></i>
                    <span>{{ s_trans('Mobil zəng') }}</span></a>
                
                <a href="#" class="px-3 btn btn-adaptive" style="background: #128c7e !important;">
                    <svg class="h-6" xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 509 511.514"><path fill="#fff" d="M434.762 74.334C387.553 26.81 323.245 0 256.236 0h-.768C115.795.001 2.121 113.696 2.121 253.456l.001.015a253.516 253.516 0 0033.942 126.671L0 511.514l134.373-35.269a253.416 253.416 0 00121.052 30.9h.003.053C395.472 507.145 509 393.616 509 253.626c0-67.225-26.742-131.727-74.252-179.237l.014-.055zM255.555 464.453c-37.753 0-74.861-10.22-107.293-29.479l-7.72-4.602-79.741 20.889 21.207-77.726-4.984-7.975c-21.147-33.606-32.415-72.584-32.415-112.308 0-116.371 94.372-210.743 210.741-210.743 56.011 0 109.758 22.307 149.277 61.98a210.93 210.93 0 0161.744 149.095c0 116.44-94.403 210.869-210.844 210.869h.028zm115.583-157.914c-6.363-3.202-37.474-18.472-43.243-20.593-5.769-2.121-10.01-3.202-14.315 3.203-4.305 6.404-16.373 20.593-20.063 24.855-3.69 4.263-7.401 4.815-13.679 1.612-6.278-3.202-26.786-9.883-50.899-31.472a192.748 192.748 0 01-35.411-43.867c-3.712-6.363-.404-9.777 2.82-12.873 3.224-3.096 6.363-7.381 9.48-11.092a41.58 41.58 0 006.357-10.597 11.678 11.678 0 00-.508-11.09c-1.718-3.18-14.444-34.357-19.534-47.06-5.09-12.703-10.37-10.603-14.272-10.901-3.902-.297-7.911-.19-12.089-.19a23.322 23.322 0 00-16.964 7.911c-5.707 6.298-22.1 21.673-22.1 52.849s22.671 61.249 25.852 65.532c3.182 4.284 44.663 68.227 108.288 95.649 15.099 6.489 26.891 10.392 36.053 13.403a87.504 87.504 0 0025.216 3.718c4.905 0 9.82-.416 14.65-1.237 12.174-1.782 37.453-15.291 42.776-30.073s5.303-27.57 3.711-30.093c-1.591-2.524-5.704-4.369-12.088-7.615l-.038.021z"/></svg>
                    {{ s_trans('Çat') }}</a>
                @foreach(($s_details['email'] ?? []) as $email)
                <a href="mailto:{{ $email['name'] }}" class="btn btn-waterdrop"><i data-feather="mail"></i><span class="hidden xxl:inline">{{ $email['name'] }}</span></a>
                @endforeach
            </div>
        </div>

        <!-- AMBULANS -->
        <div class="tile flex-col md:row-span-2 xl:row-span-4 sm:col-span-4 md:col-span-1">

            <img src="{{ asset('front/img/ambulance.png') }}" class="tile-bg" alt="ambulance_image">
            <div class="tile-title vert relative">
                <h2 class="t-heading font-light">{!! s_trans('ambulans-basliq', true) !!}</h2>
            </div>
            
            <div class="flex mt-auto px-[1.6rem] pb-[1.6rem] gap-3 relative">
                <a id="ambulance_numbers" href="tel:{{ str_replace(' ', '', $s_details['ambulance'][0]['name']) }}" 
                    class="btn px-3 mt-3 btn-adaptive" style="background-color: #ff4040 !important;">

                    <i data-feather="activity" stroke-width=2></i>
                    <span class="md:hidden">{{ s_trans('Zəng et') }}</span>
                    <span class="hidden md:inline">{{ $s_details['ambulance'][0]['name'] }}</span>
                </a>
            </div>

            
        </div>
    </div>
  
</div>

@endsection