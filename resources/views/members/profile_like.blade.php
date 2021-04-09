@extends('templates.master')
@section('title','Tin yêu thích')
@section('content')
<div id="profile-like" class="page profile blog">
    @include('members.profile_header')
	<div class="container">
		<div class="pro-wrap">
			<div id="pro-main" class="row">			
				<div class="main col-md-9">
                    <div class="main-wrap">
                        @include('members.profile_menu')
                        @if($blogs)					
                            <div class="list-item clearfix likes" data-token="{{csrf_token()}}">
                                @foreach($blogs as $item)<?php $author = getUser($item->user_id);?>
                                <div id="like-{{$item->like_id}}" class="item">                            
                                    <div class="wrap clearfix">
                                        <a href="{{$item->slug}}" class="thumb">{!!image($item->image,140,90,$item->title)!!}</a>
                                        <div class="desc">                                                             
                                            <h3><a href="{{route('postType',['slug'=>$item->slug])}}">{{$item->title}}</a></h3>
                                            <ul class="alpha-open">
                                                <li class="beta">Beta: {{ dateServerOpen($item->server_open) }}</li>
                                                <li class="alpha">Alpha: {{ dateServerOpen($item->server_alpha)}}</li>
                                            </ul>
                                            <ul class="meta">
                                                @if($author)<li class="author"><img src="{{asset('public/images/author.png')}}" alt="icons">{{$author->name}}</li>@endif                                    
                                                <li class="time"><img src="{{asset('public/images/calendar.png')}}" alt="icon"><span class="time-go" title="{{$item->created_at}}" data-time="{{$item->created_at}}">{{$item->created_at}}</span> <img src="{{asset('public/images/eye.png')}}" alt="icons" class="hidden-480"><span  class="hidden-480">{{ $item->view }}</span></li>
                                            </ul>
                                            <a href="#" class="unlike" data-value="{{$item->like_id}}"><i class="fa-heart fas"></i></a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            {!!$blogs->links()!!}
                        @endif
                    </div>
				</div>
				<div class="sidebar col-md-3 sb-left">@include('sidebars.member')</div>
			</div>
		</div>
	</div>
</div>
@endsection