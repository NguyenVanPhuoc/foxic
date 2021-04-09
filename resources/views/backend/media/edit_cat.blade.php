@extends('backend.layout.index')
@section('title', 'Sửa danh mục')
@section('content')
	<div id="edit-mediaCat" class="container page route">
		<div class="head">
			<a href="{{ route('mediaCat') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ _('Tật cả') }}</a>
			<h1 class="title">{{ $mediaCat->title }}</h1>
		</div>
		<div class="main">
			<form action="{{ route('updateMediaCat',['id'=>$mediaCat->id]) }}" class="frm-menu dev-form" method="POST" name="editMediaCat" role="form">
				{{ csrf_field() }}
				<div id="frm-title" class="form-group">
					<label for="title">{{ _('Tên danh mục') }}<small class="required">(*)</small></label>
					<input type="text" name="title" class="form-control" placeholder="Enter name category" class="frm-input" value="{{ $mediaCat->title }}">
				</div>
				<div class="group-action">
					<a href="{{ route('deleteMediaCat',['id'=>$mediaCat->id]) }}" class="btn btn-delete">{{ _('Xoá') }}</a>
					<button type="submit" name="submit" class="btn">{{ _('Cập nhật') }}</button>
					<a href="{{ route('mediaCat') }}" class="btn btn-cancel">{{ _('Huỷ') }}</a>
				</div>
			</form>
		</div>
	</div>
	<script type="text/javascript">
		$(function() {
			$("#edit-mediaCat").on('click','form .group-action button',function(){
				var _token = $("form input[name='_token']").val();
				var link = $('form').attr('action');
				var title = $("#frm-title input").val();
				if(title==""){
					new PNotify({
						title: 'Lỗi',
						text: 'Vui lòng nhập tên danh mục!',
						hide: true,
						delay: 2000,
					});
				}else{
					$('#overley').show();
					$('.loading').show();
					$.ajax({
						type:'POST',
						url: link,
						cache: false,
						data:{
							'_token': _token,
							'title': title
						},
					}).done(function(data) {
						if( data != "error"){
							$('#overley').hide();
							$('.loading').hide();
							new PNotify({
								title: 'Thành công',
								text: 'Cập nhật danh mục thành công!',
								type: 'success',
								hide: true,
								delay: 5000,
							});
							location.reload();
						}else{
							new PNotify({
								title: 'Error',
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
					text: 'Bạn muốn xoá danh mục này?',
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