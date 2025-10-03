@extends('front.layouts.master')

@section('page_title', $translations[$service->name].' - Doktor.az Klinika')

@section('main')

<div class="md:h-[80vh]">
    <div class="grid lg:grid-cols-12 lg:grid-rows-1 gap-3 h-full">
        <div class="col-span-12 md:col-span-6 lg:col-span-6 xl:col-span-4 2xl:col-span-4 grid grid-cols-1 lg:grid-rows-12 gap-2 sm:gap-3">
            <div class="tile service-intro flex-col items-start p-6 row-span-5 2xl:row-span-6" style="--service-color: {{ $service->color ? $service->color : '#3D4871' }};">
                @php
                    $cover_photo = $service->photo ? $service->photo : $service->department->photo;
                @endphp
                @if($cover_photo)
                <img src="{{ media($cover_photo) }}" alt="service_bg" class="tile-bg">
                @endif
                <a href="{{ loc_route('services') }}" class="btn btn-adaptive">
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
                        <a class="swiper-slide doctor" href="{{ loc_route('doctors.find', $doctor->slug) }}">
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
        <div class="col-span-12 md:col-span-6 lg:col-span-6 xl:col-span-5 grid grid-cols-1 lg:grid-rows-12 gap-2 sm:gap-3">
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
                <div class="flex flex-wrap pt-3 mt-auto gap-2 text-sm">
                    <a class="text-center flex items-center gap-1
                             btn-3d bg-green-400 text-white font-semibold radius-s p-3" 
                        href="tel:{{ str_replace(' ', '', $s_details['mobile'][0]['name']) }}">
                        <i data-feather="smartphone" stroke-width=2 width=20 height=20></i>
                        {{ $s_details['mobile'][0]['name'] }}</a>
                    
                    <a class="text-center flex items-center gap-2 border border-slate-300 radius-s p-3" 
                        href="tel:{{ str_replace(' ', '', $s_details['phone'][0]['name']) }}">
                        <i data-feather="phone" stroke-width=2 width=20 height=20></i>
                        <span class="hidden xl:inline">{{ $s_details['phone'][0]['name'] }}</span></a>
                    <a href="{{ $s_details['whatsapp'][0]['link'] }}" class="btn border border-slate-300 text-emerald-600 font-semibold justify-center radius-s p-3">
                        <svg class="h-5" xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 509 511.514"><path fill="#128c7e" d="M434.762 74.334C387.553 26.81 323.245 0 256.236 0h-.768C115.795.001 2.121 113.696 2.121 253.456l.001.015a253.516 253.516 0 0033.942 126.671L0 511.514l134.373-35.269a253.416 253.416 0 00121.052 30.9h.003.053C395.472 507.145 509 393.616 509 253.626c0-67.225-26.742-131.727-74.252-179.237l.014-.055zM255.555 464.453c-37.753 0-74.861-10.22-107.293-29.479l-7.72-4.602-79.741 20.889 21.207-77.726-4.984-7.975c-21.147-33.606-32.415-72.584-32.415-112.308 0-116.371 94.372-210.743 210.741-210.743 56.011 0 109.758 22.307 149.277 61.98a210.93 210.93 0 0161.744 149.095c0 116.44-94.403 210.869-210.844 210.869h.028zm115.583-157.914c-6.363-3.202-37.474-18.472-43.243-20.593-5.769-2.121-10.01-3.202-14.315 3.203-4.305 6.404-16.373 20.593-20.063 24.855-3.69 4.263-7.401 4.815-13.679 1.612-6.278-3.202-26.786-9.883-50.899-31.472a192.748 192.748 0 01-35.411-43.867c-3.712-6.363-.404-9.777 2.82-12.873 3.224-3.096 6.363-7.381 9.48-11.092a41.58 41.58 0 006.357-10.597 11.678 11.678 0 00-.508-11.09c-1.718-3.18-14.444-34.357-19.534-47.06-5.09-12.703-10.37-10.603-14.272-10.901-3.902-.297-7.911-.19-12.089-.19a23.322 23.322 0 00-16.964 7.911c-5.707 6.298-22.1 21.673-22.1 52.849s22.671 61.249 25.852 65.532c3.182 4.284 44.663 68.227 108.288 95.649 15.099 6.489 26.891 10.392 36.053 13.403a87.504 87.504 0 0025.216 3.718c4.905 0 9.82-.416 14.65-1.237 12.174-1.782 37.453-15.291 42.776-30.073s5.303-27.57 3.711-30.093c-1.591-2.524-5.704-4.369-12.088-7.615l-.038.021z"/></svg>
                    </a>
                </div>
            </div>
        </div>    
        <div class="col-span-12 lg:col-span-12 xl:col-span-3 2xl:col-span-3 tile flex-col py-6 has-read-more">
            <div class="mb-4 px-6">
                <div class="mb-1 opacity-75">{{ $translations[$service->department->name] }}</div>
                <h2 class="text-xl font-semibold">{{ s_trans('Digər sahələr') }}</h2>
            </div>
            <div class="service-tiles grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-1 2xl:grid-cols-1 gap-2 auto-rows-[60px] overflow-y-scroll pb-32 px-6">
                @foreach ($related_services as $rel_service)
                <a href="{{ loc_route('services.find', $rel_service->slug) }}" class="tile tile-service related-service">
                    @if($rel_service->icon)
                    <img src="{{ media($rel_service->icon) }}" class="service-icon" alt="serv_id_{{ $rel_service->id }}_icon">
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
