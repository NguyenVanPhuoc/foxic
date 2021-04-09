@extends('backend.layout.index')
@section('title','Sửa ảnh')
@section('content')
	<div id="edit-media" class="container page route">
		<div class="head">
			<a href="{{ route('media') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ _('Tất cả') }}</a>
			<h1 class="title">{{ $media->image_path }}</h1>
		</div>
		<div class="main">
			<form action="{{ route('updateMedia',['id'=>$media->id]) }}" class="frm-menu dev-form" method="POST" name="editmedia" role="form">
				{{ csrf_field() }}
				<div class="row">
					<div class="col-md-9 content clearfix">
						<div id="frm-title" class="form-group">
							<label for="title">{{ _('Name file') }}</label>
							<input type="text" name="title" class="form-control" placeholder="{{ _('Nhập tên ảnh') }}" class="frm-input" value="{{ $media->title }}">
						</div>
						<div id="frm-url" class="form-group">
							<label for="url">{{ _('URL') }}</label>
							<input type="text" name="title" class="form-control" class="frm-input" value="{{ url('/public/uploads').'/'.$media->image_path }}" readonly>
						</div>
						<div id="frm-image" class="desc box-wrap">{!! imageAuto($media->id,$media->title) !!}</div>
					</div>
					<div class="col-md-3 sidebar clearfix">
						@if($mediaCat)
							<?php $catIds = explode(',',$media->cat_ids);?>
							<section id="sb-categories" class="box-wrap">
								<h2 class="title">{{ _('Danh mục') }}</h2>
								<div class="desc list">
									@foreach($mediaCat as $item)
										<div class="checkbox checkbox-success item">
											<input id="cat-{{$item->id}}" type="checkbox" name="medias[]" value="{{ $item->id }}" @if(in_array($item->id,$catIds)) checked @endif>
											<label for="cat-{{$item->id}}">{{$item->title}}</label>
										</div>
									@endforeach
								</div>
							</section>
						@endif
					</div>
					<div class="col-md-9">
						<div class="group-action">
							<a href="{{ route('deleteMedia',['slug'=>$media->id]) }}" class="btn btn-delete">{{ _('Xoá') }}</a>
							<button type="submit" name="submit" class="btn">{{ _('Cập nhật') }}</button>
							<a href="{{ route('media') }}" class="btn btn-cancel">{{ _('Huỷ') }}</a>	
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<script type="text/javascript">
		$(function() {
			$("#edit-media").on('click','form .group-action button',function(){
				var _token = $("form input[name='_token']").val();
				var link = $("form").attr('action');
				var categories = new Array();
				var errors = new Array();
				var error_count = 0;
				$("#sb-categories .list .item").each(function(){
					if($(this).find("input").is(':checked')){
						categories.push($(this).find("input").val());
					}
				});
				if(categories.length == 0){
					new PNotify({
						title: 'Lỗi',
						text: 'Vui lòng nhập tên danh mục!',
						hide: true,
						delay: 2000,
					});
				}else{
					$.ajax({
						type:'POST',
						url: link,
						cache: false,
						data:{
							'_token': _token,
							'title': $("#frm-title input").val(),
							'categories': JSON.stringify(categories)
						},
					}).done(function(data) {
						if(data=="success"){
							new PNotify({
								title: 'Thành công',
								text: 'Cập nhật ảnh thành công!',
								type: 'success',
								hide: true,
								delay: 2000,
							});
						}else{
							new PNotify({
								title: 'Lỗi',
								text: 'Hệ thống quá tải. Vui lòng thử lại sau!',
								hide: true,
								delay: 2000,
							});
						}
					});
				}
				return false;
			});
			//delete location
			$(".btn-delete").click(function(){
				var href = $(this).attr("href");
				(new PNotify({
					title: 'Xoá',
					text: 'Bạn muốn xoá ảnh này?',
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
			})
		});
	</script>
@endsection