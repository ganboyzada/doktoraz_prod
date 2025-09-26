@extends('front.layouts.master')

@section('page_title', s_trans('Haqqımızda').' - Doktor.az Klinika')
{{-- @section('meta_tags', $translations[$page_meta->meta_tags]) --}}
{{-- @section('meta_desc', $translations[$page_meta->meta_desc]) --}}

@section('main')

<div class="md:h-[85vh]">
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-12 grid-rows-1 gap-3 md:gap-5 md:h-full">
        <div class="xl:col-span-4 grid md:grid-rows-4 xl:grid-rows-12 gap-2 md:gap-3">
            <div class="tile service-intro flex-col items-start p-6 md:row-span-1 xl:row-span-4 min-h-48" style="--service-color: #1A6CE7;">
                <img src="{{ asset('front/img/bg_about.png') }}" alt="" class="tile-bg">
                <a href="{{ route('home') }}" class="btn btn-adaptive">
                    <i data-feather="chevron-left"></i>
                    {{ s_trans('Ana səhifə') }}
                </a>
                <div class="mt-auto">
                    <h2 class="text-3xl md:text-4xl font-semibold">{{ s_trans('haqqimizda-basliq') }}</h2>
                    <div class="mt-2 opacity-75">{{ s_trans('DOKTOR.AZ KLİNİKASI') }}</div>
                </div>
            </div>
            <div class="tile has-read-more flex-col md:row-span-3 xl:row-span-8 p-6 pb-0">
                <div class="flex items-center mb-3">
                    <i width="30" height="30" class="mr-3" data-feather="info" ></i>
                    <h2 class="text-xl font-semibold">{{ s_trans('Ümumi Məlumat')}}</h2>
                </div>

                <div class="overflow-y-scroll h-full min-h-72">
                    <div class="h-[100px] leading-7">
                        <div class="pb-[150px]">Kardiologiya – ürək və qan dövranı sistemi xəstəliklərinin diaqnostikası, müalicəsi və profilaktikası ilə məşğul olan mühüm tibbi sahədir. Bu xidmət çərçivəsində pasiyentlər ürək ritminin pozulmaları, təzyiq problemləri, damar xəstəlikləri, ürək çatışmazlığı və digər kardioloji narahatlıqlar üzrə peşəkar həkimlər tərəfindən müayinə və müalicə alır. Klinikamız müasir avadanlıqlarla təchiz olunmuşdur və EKQ, Exokardioqrafiya, Exo, Stres testi kimi müayinələr vasitəsilə dəqiq nəticələr təqdim edir. Məqsədimiz pasiyentlərə vaxtında diaqnoz qoymaq, effektiv müalicə planı qurmaq və sağlam həyat keyfiyyətini təmin etməkdir.
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div class="xl:col-span-8">

            <div class="swiper doc-slider h-full" id="gallery_slider">
                
                <div class="swiper-wrapper">
                    @foreach (\App\Models\Content::where('type', 'gallery')->get() as $k=>$photo)
                    <div class="swiper-slide gallery-item border radius-s overflow-hidden">
                        <img src="{{ media($photo->image) }}" alt="">
                    </div>
                    @endforeach
                    @foreach (\App\Models\Content::where('type', 'gallery')->get() as $k=>$photo)
                    <div class="swiper-slide gallery-item border radius-s overflow-hidden">
                        <img src="{{ media($photo->image) }}" alt="">
                    </div>
                    @endforeach
                </div>
                <!-- Arrows -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                
            </div>
		</div>
	</div>
</div>

{{--
 media($content->image) 
 $translations[$content->value] !!}
--}}
@endsection