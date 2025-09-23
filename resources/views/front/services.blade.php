@extends('front.layouts.master')

@section('page_title', s_trans('Xidmətlər').' - Doktor.az Klinika')

@section('main')

    {{-- @isset($dep)
        @include('front.includes.breadcrumb', [
            'title' => s_trans('Xidmətlər'),
            'sublinks' => [
                    route('department.services', $dep->slug) => translate($dep->name)
                ]
            ])
    @else
        @include('front.includes.breadcrumb', ['title'=>s_trans('Xidmətlər')])
    @endisset --}}

<div class="md:h-[85vh] flex gap-2 sm:gap-3 departments">
    @foreach ($departments as $k=>$dep)
    <div class="department" data-id='{{ $k+1 }}' style="--dep-color: {{ $dep->color }};">
        <div class="dep-title flex items-center mb-4">
            <img src="{{ media($dep->photo) }}" class="dep-bg" alt="">
            <button type="button" class="back-to-categs mr-4 btn no-text btn-waterdrop w-[45px] h-[45px]"><i width="35" height="35" data-feather="chevron-left"></i></button>
            <h2 class="font-semibold">{{ $translations[$dep->name] }}</h2>
            <button type="button" class="browse-categ mr-4 btn btn-adaptive">
                {{ s_trans('shobe-duyme') }}
                <i width="35" height="35" data-feather="chevron-right"></i></button>
        </div>
        
        <div class="service-tiles grid grid-cols-2 md:grid-cols-4 auto-rows-[120px] gap-2 md:h-[90%]">
            @foreach ($dep->categories as $service)
            <a href="{{ route('services.find', $service->slug) }}" class="tile tile-service">
                @if($service->icon)
                <img src="{{ media($service->icon) }}" class="service-cover" alt="">
                @endif
                <div class="tile-title">
                    {{ $translations[$service->name] }} 
                </div>
            </a>   
            @endforeach
        </div>
    </div>
    @endforeach
</div>



@endsection