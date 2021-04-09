@extends('templates.master')
@section('title', $page->title)
@if(isset($page->key))
	@section('keywords', $page->key)
@endif
@if(isset($page->value))
	@section('description', $page->value)
@endif
@section('content')
   <div class="page">
        <div class="container">
            <div class="sec-title"><h3>{{ $page->title }}</h3></div>
            <div class="sec-content">{!! $page->content !!}</div>
        </div>
   </div>
@endsection