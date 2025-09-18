@extends('front.layouts.master')

@section('page_title', s_trans('Articles').' - Doktor.az Klinika')
@section('meta_tags', $translations[$page_meta->meta_tags])
@section('meta_desc', $translations[$page_meta->meta_desc])

@section('main')

@isset($dep)
    @include('front.includes.breadcrumb', [
        'title' => s_trans('Articles'),
        'sublinks' => [
                route('blog.filter', $dep->slug) => translate($dep->name)
            ]
        ])
@else
@include('front.includes.breadcrumb', ['title'=>s_trans('Articles')])
@endisset

{{--
@foreach ($blogposts as $post)
    <div class="blogpost-wrapper">
        <a href="{{ route('blog.find', $post->slug) }}">
            <div class="blogpost">
                <img src="{{ media($post->photo) }}" alt="">
                <!-- <div class="post-published">
                    <i class="bi bi-calendar3"></i> 
                    {{ \Carbon\Carbon::parse($post->created_at)->format('d M, Y') }} 
                </div> -->
                <div class="post-details">
                    <h3 class="title">{{ $translations[$post->title] }}</h3>
                    <div class="excerpt">
                        {!! strip_tags($translations[$post->excerpt], true) !!}
                    </div>
                    <a href="{{ route('blog.find', $post->slug) }}" class="btn-read-more">{{ s_trans('Continue reading') }}</a>
                </div>
            </div>
        </a>
    </div>
@endforeach
    
{{ $blogposts->links() }}
--}}

@endsection