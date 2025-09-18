@extends('front.layouts.master')

@section('page_title', translate($blogpost->title).' - Amerikan Aptek')
@section('meta_tags', translate($blogpost->meta_tags))
@section('meta_desc', translate($blogpost->meta_desc))

@section('main')

@php
    $sublinks = [
        route('blog') => s_trans('Articles')        
    ];

    if($blogpost->department != null){
        $sublinks[route('blog.filter', $blogpost->department->slug)] = translate($blogpost->department->name);
    }
@endphp

@include('front.includes.breadcrumb', ['sublinks'=>$sublinks,'title'=>translate($blogpost->title)])


@endsection
