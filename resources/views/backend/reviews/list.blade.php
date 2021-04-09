@extends('backend.layout.index')
@section('title','Cảm nhận khách hàng')
@section('content')
<div id="reviews" class="page">
	<div class="head">
		<h1 class="title">Cảm nhận khách hàng</h1>
	</div>
	<form id="reviwers" action="#" method="post" name="reviwer" class="dev-form">
		{{ csrf_field() }}
		<div class="tb-results">
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col" class="stt">STT</th>
						<th scope="col" class="image">Hình ảnh</th>
						<th scope="col" class="title">Tên khách hàng</th>
						<th scope="col" class="date">Ngày đăng</th>
						<th scope="col" class="action">Tác vụ</th>
					</tr>
				</thead>
				<tbody>
					<?php $count = 0;?>
					@foreach($reviews as $review) <?php $count++;?>
					<tr>
						<th class="stt">{{$count}}</th>
						<td class="image"><a href="{{ route('editReviewAdmin',['id'=>$review->id]) }}" class="edit">{!! image($review->image,100,100,$review->title) !!}</a></td>
						<td class="title"><a href="{{ route('editReviewAdmin',['id'=>$review->id]) }}">{{$review->name}}</a></td>
						<td class="date">{{$review->updated_at}}</td>
						<td class="action">
							<a href="{{ route('editReviewAdmin',['id'=>$review->id]) }}" class="edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
							<a href="{{ route('deleteReviewAdmin',['id'=>$review->id]) }}" class="delete"><i class="fa fa-close" aria-hidden="true"></i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</form>
	{{ $reviews->links() }}
</div>
@if(session('success'))
<script type="text/javascript">
	$(function(){
		new PNotify({
			title: 'Thành công',
			text: 'Xóa Thành công.',
			type: 'success',
			hide: true,
			delay: 2000,
		});
	})
</script>
@endif
<script type="text/javascript">
	$(function() {
	//delete location
	$("#reviews .delete").click(function(){
		var href = $(this).attr("href");
		(new PNotify({
			title: 'Xóa',
			text: 'Bạn muốn xóa review này?',
			icon: 'glyphicon glyphicon-question-sign',
			type: 'error',
			hide: false,
			confirm: {
				confirm: true
			},
			buttons: {
				closer: false,
				sticker: false
			},
			history: {
				history: false
			}
		})).get().on('pnotify.confirm', function() {			    
			window.location.href = href;
		});
		return false;
	});
});	
</script>
@stop