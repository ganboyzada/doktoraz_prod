@extends('front.layouts.master')

@section('page_title', 'Dr '.$doctor->first_name.' '.$doctor->last_name.' - Doktor.az Klinika')
@section('meta_desc', translate($doctor->desc))

@section('main')

<div class="md:h-[85vh] lg:h-[80vh]">
    <div class="grid lg:grid-cols-12 lg:grid-rows-1 gap-3 md:h-full">

        <div class="lg:col-span-6 lg:row-span-1">
            
            <div class="tile flex flex-col gap-4 p-6 h-full">
                <div class="flex flex-wrap gap-3 mb-3">
                    <a href="{{ loc_route('home') }}" class="px-3 pr-4 btn btn-waterdrop">
                        <i data-feather="home"></i>
                        {{ s_trans('Ana səhifə') }}
                    </a>
                    <a href="{{ loc_route('doctors') }}" class="px-3 pr-4 mr-auto btn btn-waterdrop">
                        <i data-feather="users"></i>
                        {{ s_trans('hekimler-basliq') }}
                    </a>
                    <h1 class="text-2xl lg:text-3xl leading-10">{!!'<b>Dr '.$doctor->first_name.'</b> '.$doctor->last_name !!}</h1>
                </div>
                
                <div class="flex flex-col items-start gap-4">
                    <div class="w-full grid md:grid-cols-2 lg:grid-cols-12 gap-3">
                        <div class="lg:col-span-5 radius-x bg-slate-100 relative flex lg:pt-6">
                            <div class="px-5 pt-16 pb-5 text-white absolute left-0 right-0 bottom-0 radius-s text-xl text-center uppercase font-semibold" 
                                style="background: linear-gradient(0deg, #3D4871 -30%, transparent);">
                                {{ translate($doctor->designation) }}
                            </div>
                            <img src="{{ media($doctor->photo) }}" class="mx-auto max-w-full w-[95%] h-full md:max-h-[25vh] xl:max-h-[50vh] object-contain object-bottom" alt="{{ $doctor->slug.'_img' }}">
                        </div>
                        <div class="lg:col-span-7 radius-x p-4 border border-slate-200">
                            <h2 class="text-xl font-semibold">{{ s_trans('Həkim haqqında') }}</h2>
                        </div>
                    </div>
                </div>
                
                <div class="tile items-center gap-3 md:p-3 colored-tile" style="--bg-color: {{ $doctor->category->color ? $doctor->category->color : '#3D4871' }};">
        
                    @php
                        $cover_photo = $doctor->category->photo ? $doctor->category->photo : $doctor->category->department->photo ;
                    @endphp
                    @if($cover_photo)
                    <img src="{{ media($cover_photo) }}" alt="service_bg" class="tile-bg !h-full !w-3/5 !object-cover opacity-75">
                    @endif

                    @if($doctor->category->icon)
                    <img class="h-16 md:h-20" src="{{ media($doctor->category->icon) }}" alt="">
                    @endif
                    <div class="pr-3 md:p-4 flex flex-wrap items-center w-full gap-3 z-[2]">
                        <div class="text-xl md:text-2xl mr-auto font-semibold">{{ translate($doctor->category->name) }}</div>
                        <a class="radius-s btn btn-adaptive px-5 py-1" 
                            href="{{ loc_route('services.find', $doctor->category->slug) }}">{{ s_trans('Daha ətraflı') }}</a>
                    </div>
                </div>
            </div>
            
        </div>
       
        <div class="lg:col-span-6 lg:row-span-1 tile p-6 has-read-more flex-col min-h-96">
            <div class="flex items-center mb-3">
                <i width="30" height="30" class="mr-3" data-feather="award" ></i>
                <h2 class="text-xl font-semibold">{{ s_trans('Təhsil və Təcrübələr') }}</h2>
            </div>

            <div class="overflow-y-scroll h-full min-h-96">
                <div class="h-[100px] leading-7">
                    <div class="pb-[150px]">
                        @if(translate($doctor->desc))
                        {!! translate($doctor->desc) !!}
                        @else
                        @include('front.layouts.notfound')
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
