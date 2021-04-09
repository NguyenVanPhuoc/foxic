@extends('templates.master')
@section('title', 'Notice')
@section('keywords', 'notice')
@section('description','notice')
@section('content')
    <div id="notice" class="notices">
        <div class="container">
           <div class="list-notice row">
	           	@foreach($list_notice as $notice)
	           	@php
	           		$notify = $notice->data;
	           		$item = getNoticeById(json_decode($notify)->id);
	           	@endphp
	           	<div class="col-md-4">
	           		<div class="item">
		           		<div class="thumb-img">
		           			<a href="{{ route('detailNotice', ['slug'=>$item->slug]) }}">
			           			{!! image($item->image, '360','180', $item->title) !!}
			           		</a>
		           		</div>
		           		<div class="desc">
		           			<h3 class="title"><a href="{{ route('detailNotice', ['slug'=>$item->slug]) }}">{{ $item->title }}</a></h3>
		           			<p>{{ __('Thời gian:')}} {{ date_format(date_create($item->created_at), 'd-m-Y H:i:s') }}</p>
		           			<div class="text">
		           				{!! $item->content !!}
		           			</div>
		           		</div>
	           		</div>
	           	</div>
	           	@endforeach
           </div>
          {{ $list_notice->links() }}
        </div>
    </div>
@endsection