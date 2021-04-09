@extends('templates.master')
@section('title','Truyện đã mua')
@section('content')
<div id="chapHistory" class="page profile">
	@include('members.menu_chap')
	<div class="content-book">
		<div class="container">
			<div class="list-chap buy-chaps">
				@if(isset($list_buy) && $list_buy!=null)
					@foreach($comics as $key => $item)		
					
						<div class="item">
							<div class="desc-left">
								<a href="{{ route('listChap',$item->slug) }}" class="link"></a>
								{!! image($item->image, 112 , 84 , $item->title)!!}
								<h4 class="title-h4">{{ $item->title }}</h4>
								{!! str_limit($item->desc, 55) !!}
								<p>{!! getObjSlugTitleUserInComicST($item->user_id) !!}</p>
							</div>
						</div>
					@endforeach
				@else
				<div class="wrapper-no-data">
			        <img src="{{ asset('public/images/FoxicXX.png') }}" alt="img-no-data">
			        <h2 class="title">Bạn chưa mua truyện nào!</h2>
			        <p class="text">Tất cả chương truyện được mua đều có thời hạn nhất định, thời hạn được hiển thị trên chương sau khi mua. 
					Bạn có thể đọc chương đó trên mọi nền tảng được hỗ trợ</p>
			    </div>
				@endif
			</div>
		</div>
	</div>
</div>	
@endsection