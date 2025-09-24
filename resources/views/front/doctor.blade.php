@extends('front.layouts.master')

@section('page_title', 'Dr '.$doctor->first_name.' '.$doctor->last_name[0].' - Doktor.az Klinika')

@section('main')

<div class="md:h-[85vh]">
    <div class="grid lg:grid-cols-1 xl:grid-cols-12 lg:grid-rows-12 xl:grid-rows-1 gap-3 md:h-full">

        <div class="col-span-12 lg:col-span-1 xl:col-span-5 lg:row-span-4 xl:row-span-1 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-1 gap-3">
            
            <div class="tile flex flex-col p-6">
                <div class="flex gap-3 pb-4 mb-auto">
                    <a href="{{ route('home') }}" class="btn btn-waterdrop">
                        <i data-feather="home"></i>
                        {{ s_trans('Ana səhifə') }}
                    </a>
                    <a href="{{ route('doctors') }}" class="btn btn-waterdrop">
                        <i data-feather="users"></i>
                        {{ s_trans('hekimler-basliq') }}
                    </a>
                </div>
                <div class="flex gap-3 md:items-stretch flex-col md:flex-row mb-4">
                    <div class="radius-x md:min-w-[50%] h-[40vh] bg-gray-100 p-4 pb-0">
                        <img src="{{ media($doctor->photo) }}" class="w-full h-full object-contain" alt="{{ $doctor->slug.'_img' }}">
                    </div>
                    <div class="p-5 radius-x flex flex-col justify-center border border-gray-200 items-start gap-3">
                        <h1 class="text-3xl md:w-[70%] leading-10">{!!'<b>Dr '.$doctor->first_name.'</b> '.$doctor->last_name !!}</h1>
                        <div class="btn btn-3d px-4 py-1 text-lg font-bold text-white" style="background-color: {{ $doctor->category->color ? $doctor->category->color : '#3D4871' }};">{{ $translations[$doctor->designation] }}</div>
                    </div>
                </div>
                <div class="tile items-center p-3 colored-tile" style="background-color: {{ $doctor->category->color ? $doctor->category->color : '#3D4871' }};">
        
                    @if($doctor->category->icon)
                    <img class="h-32" src="{{ media($doctor->category->icon) }}" alt="">
                    @endif
                    <div class="py-4 flex flex-col items-start text-white gap-3">
                        <div class="text-2xl font-bold">{{ $translations[$doctor->category->name] }}</div>
                        <a class="radius-s border border-white/50 text-white px-5 py-1 text-lg font-bold" 
                            href="{{ route('services.find', $doctor->category->slug) }}">{{ s_trans('Daha ətraflı') }}</a>
                    </div>
                </div>
            </div>
            
        </div>
       
        <div class="col-span-12 lg:col-span-1 xl:col-span-7 lg:row-span-8 xl:row-span-1 tile p-6 has-read-more flex-col min-h-96">
            <div class="flex items-center mb-3">
                <i width="30" height="30" class="mr-3" data-feather="award" ></i>
                <h2 class="text-xl font-semibold">{{ s_trans('Təhsil və Təcrübələr') }}</h2>
            </div>

            <div class="overflow-y-scroll h-full min-h-96">
                <div class="h-[100px] leading-7">
                    <div class="pb-[150px]">
                        {!! $translations[$doctor->desc] !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
