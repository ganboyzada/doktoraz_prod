@extends('front.layouts.master')

@section('page_title', s_trans('About us').' - Doktor.az Klinika')
{{-- @section('meta_tags', $translations[$page_meta->meta_tags]) --}}
{{-- @section('meta_desc', $translations[$page_meta->meta_desc]) --}}

@section('main')

<div class="md:h-[85vh]">
    <div class="grid lg:grid-cols-1 xl:grid-cols-12 md:grid-rows-3 lg:grid-rows-12 xl:grid-rows-1 gap-3 md:h-full">
        <div class="lg:col-span-1 xl:col-span-4 lg:row-span-3 xl:row-span-1 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-1 xl:grid-rows-12 gap-3">
            <div class="tile service-intro flex-col items-start p-6 xl:row-span-5 min-h-48" style="--service-color: #1A6CE7;">
                <img src="{{ asset('front/img/bg_about.png') }}" alt="" class="tile-bg">
                <a href="{{ route('home') }}" class="btn btn-adaptive">
                    <i data-feather="chevron-left"></i>
                    Ana səhifə
                </a>
                <div class="mt-auto">
                    <h2 class="text-3xl md:text-4xl font-semibold">Haqqımızda</h2>
                    <div class="mt-2 opacity-75">Doktor.az Klinikası</div>
                </div>
            </div>
            <div class="tile block xl:row-span-7 pl-3 md:pl-6 pr-0 pt-0 pb-6">
                <div class="swiper doc-slider h-full" id="doc_slider">
                    <div class="mt-5 mb-3 pl-3 md:pl-0">
                        <h2 class="text-xl font-semibold">Qalereya</h2>
                    </div>
                    <div class="swiper-wrapper">
                        @foreach (['Dr Etiram Musayev', 'Dr Xumar Muradova', 'Dr Əli Zamanov'] as $k=>$slide)
                        <div class="swiper-slide gallery-item !h-[80%] border radius-s">
                            <img class="!object-contain" src="{{ asset('front/img/fg_docs_'. $k+1 .'.png') }}" alt="">
                        </div>
                        @endforeach
                    </div>
                    <!-- Arrows -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                    
                </div>
            </div>
        </div>
		<div class="lg:col-span-1 xl:col-span-5 lg:row-span-5 xl:row-span-1 grid grid-cols-1 xl:grid-cols-1">
			<div class="tile has-read-more flex-col p-6 pb-0">
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
		</div>
		<div class="lg:col-span-1 xl:col-span-5 lg:row-span-4 xl:row-span-1 grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-1">
			
		</div>
	</div>
</div>

{{--
 media($content->image) 
 $translations[$content->value] !!}
--}}
@endsection