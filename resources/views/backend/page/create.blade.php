@extends('backend.layout.index')
@section('title','Thêm trang')
@section('content')
	<div id="create-page" class="container page">
		<div class="head">
			<a href="{{ route('pagesAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ _('Tất cả') }}</a>
			<h1 class="title">{{ _('Add page') }}</h1>
		</div>
		<form id="add-page" action="{{ route('storePageAdmin') }}" method="post" name="addPage" class="dev-form add-form">
			{{ csrf_field() }}
			<div id="frm-title" class="form-group section">
				<label for="title">{{ _('Tên trang') }}<small>(*)</small></label>
				<input type="text" name="title" class="form-control" value="{{old('title')}}">
			</div>
			<div id="frm-editor" class="form-group section">
				<label for="name">{{ _('Nội dung') }}<small>(*)</small></label>
				<textarea name="content" id="editor"></textarea>
			</div>
			<div id="frm-metaKey" class="form-group">
				<label for="metakey">{{ _('Từ khoá') }}</label>
				<input type="text" name="metakey" class="form-control" placeholder="{{ _('Nhập từ khoá SEO') }}" class="frm-input">
			</div>
			<div id="frm-metaValue" class="form-group">
				<label class="metaValue">{{ _('Nội dung SEO') }}</label>
				<textarea name="metaValue" placeholder="{{ _('Nhập nội SEO') }}" class="form-control"></textarea>
			</div>
			<div class="group-action">
				<button type="submit" name="submit" class="btn">{{ _('Lưu') }}</button>
				<a href="{{ route('pagesAdmin') }}" class="btn btn-cancel">{{ _('Huỷ') }}</a>
			</div>
		</form>
	</div>
	<script type="text/javascript">
		ckeditor("editor");
		$(document).ready(function(){
			$("#create-page .group-action button").click(function(){
				var _token = $("input[name='_token']").val();
				var link = $('.dev-form').attr('action');
				var title = $("#frm-title input").val();
				var content = CKEDITOR.instances['editor'].getData();
				var metaKey = $("#frm-metaKey input").val();
				var metaValue = $("#frm-metaValue textarea").val();
				var errors = new Array();
				var error_count = 0;
				if(title == "") errors.push("Vui lòng nhập tên trang!") 
				if(content=="") errors.push("Vui lòng nhập nội dung trang!")
				var i;
				var html = "<ul>";
				for(i = 0; i < errors.length; i++){
					if(errors[i] != ""){
						html +='<li>'+errors[i]+'</li>';
						error_count += 1;
					}
				}
				if(error_count>0){
					html += "</ul>";
					new PNotify({
						title: 'Error ('+error_count+')',
						text: html,
						hide: true,
						delay: 6000,
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
							'title': title,
							'content': content,
							'metaKey': metaKey,
							'metaValue': metaValue
						},
						success:function(data){
							if(data == "success"){
								$('#overlay').hide();
								$('.loading').hide();
								new PNotify({
									title: 'Thành công',
									text: 'Thêm trang thành công',
									type: 'success',
									hide: true,
									delay: 2000,
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
						}
					});
				}
				return false;
			});
		});
	</script>
@endsection