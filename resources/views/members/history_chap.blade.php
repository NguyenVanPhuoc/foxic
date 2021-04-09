@extends('templates.master')
@section('title','Lịch sử đọc truyện')
@section('content')
<div id="chapHistory" class="page profile">
	@include('members.menu_chap')
	<div class="content-book">
		<div class="container">
			<div class="list-chap">
				@if(isset($list_history) && $list_history!=null)
					@php
						$value = json_decode($list_history->value);
						$list_history =collect($value)->sortByDesc('time')->toArray();
					@endphp
					<div class="item item-top">
						<div class="desc-left">
							<p class="title-chap">{{ __('Hiển thị 25 nội dung được đọc gần đây nhất') }}</p>
						</div>
						<div class="time-right">
							{{ __('Ngày đọc ')}}
						</div>
					</div>
					@php
						$count=0;
					@endphp
					@foreach($list_history as $key => $item)			
						@php
							$count++;
							if($count > 25) break;
							$comic= getComicById($item->comic_id);
							$chap= getChapByID($item->chap_id);
						@endphp
						<div class="item {{$count}}">
							<div class="desc-left">
								<a href="{{ route('listChap',$comic->slug) }}" class="link"></a>
								{!! image($comic->image, 112 , 84 , $comic->title)!!}
								<h4 class="title-h4">{{ $comic->title }}</h4>
								@if($chap != null)
								<p class="title-chap"><i class="far fa-bookmark"></i>{{ $chap->chap }}: {{ $chap->title }}</p>
								@endif
							</div>
							<div class="time-right">
								{{ __('Đọc cách đây ')}}{{ timeElapsedString($item->time) }}
							</div>
						</div>
					@endforeach
				@else
					<div class="wrapper-no-data">
				        <img src="{{ asset('public/images/FoxicXX.png') }}" alt="img-no-data">
				        <h2 class="title">Bạn chưa đọc truyện nào!</h2>
				    </div>
				@endif
			</div>
		</div>
	</div>
</div>	
@endsection