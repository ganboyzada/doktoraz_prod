@extends('front.layouts.master')

@section('page_title', s_trans('xeberler_meta_basliq'))
@section('meta_tags', translate($page_meta->meta_tags))
@section('meta_desc', translate($page_meta->meta_desc))

@section('main')
<div class="px-4 md:px-0 flex gap-4 items-center mb-4">
    <a href="{{ loc_route('home') }}" class="btn btn-waterdrop">
        <i data-feather="home" stroke-width=1.5></i>
        {{ s_trans('Ana səhifə') }}</a>
    <h1 class="text-2xl">{{ s_trans('Xəbərlər') }}</h1>
</div>

<div class="grid sm:grid-cols-2 xl:grid-cols-3 auto-rows-[240px] gap-2 sm:gap-3">

@foreach ($blogposts as $post)
    <div class="blogpost-wrapper">
        <a href="{{ loc_route('news.find', $post->slug) }}">
            <div class="blogpost grid grid-cols-5 radius-x overflow-hidden tile h-full">
                <img class="col-span-2 h-full w-full object-cover" src="{{ media($post->photo) }}" alt="">
                
                <div class="col-span-3 post-details p-4 flex flex-col items-start gap-2">
                    <div class="post-published flex gap-1 text-sm">
                        <i data-feather="calendar" height=20 width=20></i> 
                        <span class="pt-[2px]">{{ \Carbon\Carbon::parse($post->created_at)->format('d.m.Y') }} </span>
                    </div>
                    <h3 class="title text-lg font-semibold">{{ translate($post->title) }}</h3>
                    <div class="excerpt text-xs opacity-75">
                        {!! strip_tags(translate($post->excerpt), true) !!}
                    </div>
                    
                    <span class="mt-2 px-4 btn btn-waterdrop text-sm">{{ s_trans('Məlumat al') }}</span>
                </div>
            </div>
        </a>
    </div>
@endforeach
</div>
{{ $blogposts->links() }}



@endsection