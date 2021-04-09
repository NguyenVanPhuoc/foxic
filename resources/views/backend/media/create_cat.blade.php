@extends('backend.layout.index')
@section('title','Thêm danh mục')
@section('content')
	<div id="create-category" class="container page route">
		<div class="head">
			<a href="{{ route('mediaCat') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ _('Tất cả') }}</a>
			<h1 class="title">{{ _('Thêm danh mục') }}</h1>
		</div>
		<div class="main">
			<form action="{{ route('storeMediaCat') }}" class="frm-menu dev-form" method="POST" name="createMediaCat" role="form">
				{{ csrf_field() }}
				<div id="frm-title" class="form-group">
					<label for="title">{{ _('Tên danh mục') }}<small class="required">(*)</small></label>
					<input type="text" name="title" class="form-control" placeholder="{{ _('Enter name category') }}" class="frm-input">
				</div>
				<div class="group-action">
					<button type="submit" name="submit" class="btn">{{ _('Thêm') }}</button>
					<a href="{{ route('mediaCat') }}" class="btn btn-cancel">{{ _('Huỷ') }}</a>
				</div>
			</form>	
		</div>
	</div>
	<script type="text/javascript">
		$(function() {
			$("#create-category").on('click','form .group-action button',function(){
				var _token = $("form input[name='_token']").val();
				var link = $("form").attr('action');
				var title = $("#frm-title input").val();	
				if(title == ""){
					new PNotify({
						title: 'Lỗi',
						text: 'Vui lòng nhập tên danh mục!',
						hide: true,
						delay: 2000,
					});
				}else{
					$('#overlay').show();
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
						if(data != "error"){
							$('#overlay').hide();
							$('.loading').hide();
							new PNotify({
								title: 'Thành công',
								text: 'Thêm danh mục thành công',
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
		});
	</script>
@endsection