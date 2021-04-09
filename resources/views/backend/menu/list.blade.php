@extends('backend.layout.index')
@section('title','Menu')
@section('content')
@if(session('success'))
<script type="text/javascript">
	$(function(){
		new PNotify({
		    title: 'Thành công',
		    text: 'Xóa menu thành công.',
		    type: 'success',
		    hide: true,
		    delay: 2000,
		});
	})
</script>
@endif
<div id="menu-page" class="container page menu-page">
	<div class="head">
		<h1 class="title">Menu</h1>
		<a href="{{route('storeMenu')}}" class="btn">Thêm menu</a>
	</div>
	<div class="main row">		
		<div class="col-md-4 left-box sidebar-desc">
			<h2>Menus</h2>
			<div class="desc">
				<p>Danh sách menu sẽ giúp khách hàng duyệt web của bạn dễ dàng hơn.</p>				
			</p>Danh sách menu còn có thể sử dụng để <a href="#" target="_blank">tạo menu đa cấp</a> cho trang web của bạn.</p>
		</div>
	</div>
	<div class="col-md-8 right-box">
		@if($menus)
			@foreach($menus as $menu)
				<section class="box-wrap">
					<h2 class="title">{{$menu->title}} <a href="{{route('editMenu',['id'=>$menu->id])}}">Sửa menu <i class="fa fa-angle-down" aria-hidden="true"></i></a></h2>
					<?php $menuMetas = getSubMenu($menu->id);?>
					@if(!empty($menuMetas))
					<ul class="sortable list-item">
						@foreach($menuMetas as $meta)<?php $check = get_childrenMenu($meta->id)?>
						<li class="ui-state-default">{{$meta->title}}							
							<a href="{{route('storeSubMenu',['id'=>$meta->id])}}"><?php if(count($check)>0) echo 'Sửa'; else echo 'Tạo';?></a></li>
						@endforeach
					</ul>
					@endif
				</section>
			@endforeach
			{!!$menus->links();!!}
		@endif		
		<div class="btn-help"><i class="fa fa-question-circle-o" aria-hidden="true"></i> Bạn có thể xem hướng dẫn tạo Menu <a href="#">tại đây</a></div>
	</div>
</div>
@stop