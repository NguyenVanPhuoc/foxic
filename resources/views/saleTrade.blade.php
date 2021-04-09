@extends('templates.master')
@section('title',$page->title)
@section('content')
@php
    $banner_img = asset('public/images/bgs/review-bg.jpg'); 
    $breadcrumbs = '<div class="container">'.Breadcrumbs::render('page', $page).'</div>';
@endphp	
<div id="contact-page" class="page">
    @include('banners.banner')
    <div class="page-content">
        <div class="container">
            <h2 class="title">{{ $page->title }}</h2>
            @if(session('message')){!! session('message') !!}@endif
            <div class="content"><div class="box">{!! $page->content !!}</div></div>
        </div>
    </div>
</div>
@endsection