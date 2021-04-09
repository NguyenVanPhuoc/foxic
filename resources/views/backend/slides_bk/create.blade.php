@extends('backend.layout.index')
@section('title','Thêm slide')
@section('content')
<div id="add-slide-page" class="container page menu-page slides">
	<div class="head">
		<a href="{{ route('slidesAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> Slides</a>
		<h1 class="title">Thêm Slide</h1>
	</div>
	<div class="main">
		<form id="create-slide" action="{{ route('storeSlideAdmin') }}" class="frm-menu dev-form" method="POST" name="create_slide" role="form"/>
			{{ csrf_field() }}
			<div class="row">
				<div class="col-md-12 left-box">
					<section class="box-wrap box-title">
						<h2 class="title">Tên</h2>
						<input type="text" name="title" placeholder="Nhập tên slide..." class="mn-title frm-input">
					</section>
					<section class="box-wrap mn-link">
						<h2 class="title">Hàng</h2>
						<div class="list">
							<p class="empty">Chưa có hàng nào.</p>
							<ul class="sortable" data-recores="0">
							</ul>
						</div>
						<button class="btn-add"><i class="fa fa-plus-circle" aria-hidden="true"></i> Thêm hàng</button>
					</section>
				</div>
			</div>
			<div class="group-action">
				<a href="{{route('slidesAdmin')}}" class="btn btn-cancel">Hủy</a>
				<button type="submit" name="submit" class="btn">Lưu</button>
			</div>
		</form>
	</div>
</div>
@include('backend.media.library')
	<script type="text/javascript">
		$(function() {		
			$(".sortable" ).sortable({
				update: function(e, ui) {
					var count = 0;
					$(".sortable .ui-state-default").each(function(){
						count = count + 1;
						$(this).attr("data-position",count);
					});
				}
			});	
			//add recore
			$(".menu-page").on('click','.btn-add',function(){
				$("#add-slide-page .left-box .list .empty").remove();
				var recores = $(".mn-link .list .sortable").attr("data-recores");
				number = parseInt(recores) + 1;
				$(this).parents(".box-wrap").find(".sortable").attr("data-recores",number);
				var html = '';
				html += '<li class="ui-state-default item-'+number+' new" data-position="'+number+'">';
					html += '<div class="link-title row">';
					html += '<div class="col-md-10 frm-text"><textarea rows=3 type="text" name="contents[]" placeholder="Nhập nội dung" class="frm-input" /></div>';
					html += '<div id="image-'+number+'-1" class="col-md-2 img-upload"><div class="image"><a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>{!!image("",150,150,"image")!!}<input type="hidden" name="image" class="thumb-media" value="" /></div></div>';
					html += '<div id="image-'+number+'-2" class="col-md-2 img-upload"><div class="image"><a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>{!!image("",150,150,"image")!!}<input type="hidden" name="image_second" class="thumb-media" value="" /></div></div>';
					html += '</div>';
					html += '<i class="fa fa-trash" aria-hidden="true"></i>';
				html += '</li>';
				$(".list .sortable").append(html);
				return false;
			});
			//delete record   
			$(".sortable").on('click','i.fa-trash',function(){
				$(this).parents(".ui-state-default").remove();
				var count = 0;
				$(".sortable .ui-state-default").each(function(){
					count = count + 1;
					$(this).attr("data-position",count);
				});
			});
		//create menu
		$(".menu-page").on('click','.frm-menu .group-action button',function(){
				var _token = $(".frm-menu input[name='_token']").val();
				var link = $('.frm-menu').attr('action');
				var title = $(".frm-menu .box-title input").val();
				var new_metas = new Array();
				var new_count = 0;
				var errors = new Array();
				var error_count = 0;
				$(".menu-page .list .sortable .ui-state-default").each(function(){
					var text = $(this).find(".frm-text textarea").val();
					var image = $(this).find('.img-upload input[name="image"]').val();
					var image_second = $(this).find('.img-upload input[name="image_second"]').val();
					if(image != ""){
						new_metas[new_count] = {
							'text' : text,
							'image' : image,
							'image_second' : image_second,
							'position' : $(this).attr("data-position"),
						}
						new_count = new_count + 1;
					}
				});
				if(title=="") errors.push("Vui lòng nhập tiêu đề");
				if(new_metas.length==0) errors.push("Một hoặc nhiều hàng chưa chọn hình ảnh!");
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
					var new_metas= JSON.stringify(new_metas);
					$('#overlay').show();
					$('.loading').show();
					$.ajax({
							type:'POST',
							url: link,
							cache: false,
							data:{
								'_token': _token,
								'title':title,
								'metas': new_metas
							},
					}).done(function(data) {
						$('#overlay').hide();
						$('.loading').hide();
						new PNotify({
							title: 'Thành công',
							text: 'Thêm slide thành công.',
							type: 'success',
							hide: true,
							delay: 5000,
						});
						location.reload();
					});
			}
			return false;
			});
		});	
	</script>
@endsection