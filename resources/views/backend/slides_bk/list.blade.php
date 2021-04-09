@extends('backend.layout.index')
@section('title','Slides')
@section('content')
@if(session('success'))
<script type="text/javascript">
	$(function(){
		new PNotify({
			title: 'Thành công',
			text: 'Xóa slide thành công.',
			type: 'success',
			hide: true,
			delay: 2000,
		});
	})
</script>
@endif
<div id="slide-page" class="container page menu-page">
	<div class="head">
		<h1 class="title">Slides</h1>
		<a href="{{route('storeSlideAdmin')}}" class="btn">Thêm slide</a>
	</div>
	<div class="main row">		
		<div class="col-md-4 left-box sidebar-desc">
			<h2>Slides</h2>
			<div class="desc">
				<p>Danh sách slides sẽ giúp khách hàng duyệt web của bạn dễ dàng hơn.</p>		
			</div>
		</div>
		<div class="col-md-8 right-box">
			@if($slides)			
			<section class="box-wrap">
				<ul class="sortable list-item">
				@foreach($slides as $item)									
					<li class="ui-state-default">
						{{$item->title}}
						<a href="{{route('editSlideAdmin',['id'=>$item->id])}}">Sửa <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					</li>
					@endforeach
				</ul>
			</section>	
			@endif
		</div>
	</div>
</div>
@stop