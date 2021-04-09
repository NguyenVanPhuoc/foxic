@extends('backend.layout.index')
@section('title','Sửa đánh giá')
@section('content')
<div id="edit-review" class="container page route">
	<div class="head">
		<a href="{{ route('reviewAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> Tất cả</a>
		<h1 class="title">Sửa Đánh Giá</h1>
	</div>
	<form id="update-reviewer" action="{{ route('updateReviewAdmin',['id'=>$reviewer->id ]) }}" method="post" name="updateReviewer" class="dev-form edit-post" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{csrf_token()}}"/>
		<div class="row">
			<div class="col-md-9 content">
				<div id="frm-title" class="form-group section">
					<label for="title">Tiêu đề<small>(*)</small></label>
					<input type="text" name="title" class="form-control title" value="{{$reviewer->name}}" />		
				</div>
				<div id="frm-editor" class="form-group section">
					<label for="name">Nội dung<small>(*)</small></label>
					<textarea name="content" id="editor">{!! $reviewer->content !!}</textarea>
				</div>
			</div>	
			<div class="col-md-3 sidebar">
				<section id="sb-image" class="box-wrap">
					<h2 class="title">Ảnh đại diện</h2>
					<div id="frm-image" class="desc img-upload">
						<div class="image">
							<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
							{!!image($reviewer->image, 150,150, $reviewer->title)!!}
							<input type="hidden" name="image" class="thumb-media" value="{{$reviewer->image}}" />
						</div>
					</div>
				</section>
			</div>
		</div>
		<div class="group-action">
			<a href="{{ route('deleteReviewAdmin',['id'=>$reviewer->id]) }}}" class="btn btn-delete">Xóa</a>
			<button type="submit" class="btn btn-primary">Sửa</button>
			<a href="{{ route('reviewAdmin') }}" class="btn come-back">Trở lại</a>
		</div>	
	</form>
	@include('backend.media.library')
</div>
<script type="text/javascript">
	ckeditor("editor");
	$(function() {
		$("#edit-review").on('click','form .group-action button',function(e){
			e.preventDefault();
			var _token = $("form input[name='_token']").val();
			var link = $("form").attr('action');
			var title = $("#frm-title input").val();
			var content = CKEDITOR.instances['editor'].getData();
			var image = $("#frm-image input").val();
			var errors = new Array();
			var error_count = 0;			
			if(title=="") errors.push("Vui lòng nhập tiêu đề");
			if(content=="") errors.push("Vui lòng nhập nội dung");
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
					title: 'Lỗi dữ liệu ('+error_count+')',
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
						'image': image
					},
				}).done(function(data) {
					$('#overlay').show();
					$('.loading').show();
					if(data=="success"){
						new PNotify({
							title: 'Thành công',
							text: 'Cập nhật thành công.',
							type: 'success',
							hide: true,
							delay: 2000,
						});
						location.reload();
					}else{
						new PNotify({
							title: 'Lỗi',
							text: 'Trình duyệt không hỗ trợ javascript.',
							hide: true,
							delay: 2000,
						});
					}
				});
			}
			return false;
		});
		$(".dev-form .btn-delete").click(function(){
      		var href = $(this).attr("href");
      		(new PNotify({
			    title: 'Xóa',
			    text: 'Bạn muốn xóa đánh giá này?',
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