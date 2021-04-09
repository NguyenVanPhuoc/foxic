@extends('backend.layout.index')
@section('title','Thêm đánh giá')
@section('content')
<div id="create-review" class="container page route">
	<div class="head">
		<a href="{{ route('reviewAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> Tất cả</a>
		<h1 class="title">Thêm đánh giá</h1>		
	</div>
	<form id="add-review" action="{{ route('createReviewAdmin') }}" method="post" name="addReview" class="dev-form add-form" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="row">
			<div class="col-md-9 content">
				<div id="frm-title" class="form-group">
					<label for="title">Tiêu đề<small>(*)</small></label>
					<input type="text" name="title" class="form-control title" value="{{old('title')}}" />		
				</div>
				<div id="frm-editor" class="form-group">
					<label for="name">Nội dung<small>(*)</small></label>
					<textarea name="content" id="editor"></textarea>
				</div>
			</div>
			<div class="col-md-3 sidebar">
				<section id="sb-image" class="box-wrap">
					<h2 class="title">Ảnh đại diện</h2>
					<div id="frm-image" class="desc img-upload">
						<div class="image">
							<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
							{!!image('', 150,150, 'cmnd mat truoc')!!}
							<input type="hidden" name="image" class="thumb-media" value="{{old('image')}}" />
						</div>
					</div>
				</section>
			</div>
		</div>
		<div class="group-action">
			<a href="{{ route('reviewAdmin') }}" class="btn btn-cancel">Hủy</a>
			<button type="submit" name="submit" class="btn">Thêm</button>
		</div>
	</form>
	@include('backend.media.library')
</div>
<script type="text/javascript">
	ckeditor("editor");
	$(function() {
		$("#create-review").on('click','form .group-action button',function(e){
			e.preventDefault();
			var _token = $("form input[name='_token']").val();
			var link = $("form").attr('action');
			var title = $("#frm-title input").val();
			var content = CKEDITOR.instances['editor'].getData();
			var image = $("#frm-image input").val();
			var errors = new Array();
			var error_count = 0;
			if(title==""){
				errors[0] = "Vui lòng nhập tiêu đề";
			}else{
				errors[0] = "";
			}
			if(content==""){
				errors[1] = "Vui lòng nhập nội dung";
			}else{
				errors[1] = "";
			}
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
					if(data=="success"){
						$("#frm-title input").val("");
						CKEDITOR.instances['editor'].setData("");
						var img_url = location.protocol + "//" + location.host+'/image/noimage.png/150/150';
						$("#frm-image . img").attr("src",img_url);
						$("#frm-image .thumb-media").val("");
						errors = [];
						error_count = 0;				       					       	
						new PNotify({
							title: 'Thành công',
							text: 'Thêm thành công.',
							type: 'success',
							hide: true,
							delay: 2000,
						});						
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
	});
</script>
@stop