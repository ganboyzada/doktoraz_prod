@extends('front.layouts.master')

@section('page_title', s_trans('DOKTOR.AZ KLİNİKASI').' - '.s_trans('page_title_xidmetler'))
@section('meta_tags', translate($page_meta->meta_tags))
@section('meta_desc', translate($page_meta->meta_desc))

@section('main')

<div class="md:h-[80vh] flex gap-2 sm:gap-3 departments">
    @foreach ($departments as $k=>$dep)
    <div class="department" data-id='{{ $k+1 }}' style="--dep-color: {{ $dep->color }};">
        <div class="dep-title flex items-center mb-4">
            <img src="{{ media($dep->photo) }}" class="dep-bg" alt="">
            <button type="button" class="back-to-categs mr-4 btn no-text btn-waterdrop w-[45px] h-[45px]"><i width="35" height="35" data-feather="chevron-left"></i></button>
            <h2 class="font-semibold">{{ translate($dep->name) }}</h2>
            <button type="button" class="browse-categ mr-4 btn btn-adaptive">
                {{ s_trans('shobe-duyme') }}
                <i width="35" height="35" data-feather="chevron-right"></i></button>
        </div>
        
        <div class="service-tiles grid md:grid-cols-2 lg:grid-cols-4 auto-rows-[100px] gap-2 sm:gap-3 md:h-[90%]">
            @foreach ($dep->categories as $service)
            <a href="{{ loc_route('services.find', $service->slug) }}" class="tile tile-service">
                @if($service->icon)
                <img src="{{ media($service->icon) }}" class="service-icon" alt="serv_id_{{ $service->id }}_icon">
                @endif
                <div class="tile-title">
                    {{ translate($service->name) }} 
                </div>
            </a>   
            @endforeach
        </div>
    </div>
    @endforeach
</div>

@endsection