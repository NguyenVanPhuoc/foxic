@extends('backend.layout.index')
@section('title','Sửa trang')
@section('content')
	@php
		use App\GroupMetas;
		use App\Metas;
		$groupMetas = GroupMetas::where('post_id','=',$page->id)->get();
		if($seo){
			$key = $seo->key;
			$value = $seo->value;
		}else{
			$key = "";
			$value = "";
		}
	@endphp
	<div id="edit-page" class="container page single-page">
		<div class="head">
			<div class="nav">
				<a href="{{ route('pagesAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ _('Tất cả') }}</a>
				<a href="{{ route('page',['slug'=>$page->slug]) }}" class="view">{{ _('Xem trước') }} <i class="fa fa-angle-right" aria-hidden="true"></i></a>
			</div>
			<h1 class="title">{{ $page->title }}</h1>			
		</div>
		<form action="{{ route('editPageAdmin',['id'=>$page->id]) }}" method="POST" name="editPage" class="dev-form edit-post">
			{{ csrf_field() }}
			<div id="post-title" class="form-group section">
				<label for="title">{{ _('Tên trang') }}<small>(*)</small></label>
				<input type="text" name="title" class="form-control" value="{{ $page->title }}"/>
			</div>
			<div id="post-content" class="form-group section">
				<label for="name">{{ _('Nội dung') }}<small>(*)</small></label>
				<textarea name="content" id="editor">{{ $page->content }}</textarea>
			</div>
			@foreach ($groupMetas as $group)
			<?php $group = GroupMetas::findBySlug($group->slug);	
			$metas = Metas::where('groupmeta_id','=', $group->id)->get();
			echo '<div id="fields" class="row">';
			foreach ($metas as $meta): ?>
				<div id="{{ $meta->id }}" class="item col-md-{{ $meta->width }}">
					<div class="form-group">
						<label for="meta_name">{{ $meta->title }}<small>(*)</small></label>
						<?php if($meta->type=="text"):?>
							<input type="text" name="meta_{{ $meta->id }}" id="meta_{{ $meta->id }}" class="form-control meta-value" value="{{ $meta->content }}" data-type="{{ $meta->type }}" />
							<?php elseif($meta->type=="textarea"):?>
								<textarea name="meta_{{ $meta->id }}" id="meta_{{ $meta->id }}" class="form-control meta-value" data-type="{{ $meta->type }}">{{ $meta->content }}</textarea>
								<?php else:?>
									<textarea name="meta_{{ $meta->id }}" id="meta_{{ $meta->id }}" class="form-control meta-value" data-type="{{ $meta->type }}">{{ $meta->content }}</textarea>
									<script type="text/javascript">ckeditor("meta_{{ $meta->id }}")</script>
								<?php endif;?>
							</div>
						</div>
					<?php endforeach;?>
				</div>
				@endforeach
				<div id="frm-metaKey" class="form-group">
					<label for="metakey">{{ _('Từ khoá') }}</label>
					<input type="text" name="metakey" class="form-control" placeholder="{{ _('Nhập từ khoá SEO') }}" class="frm-input" value="{{ $key }}">
				</div>
				<div id="frm-metaValue" class="form-group">
					<label class="metaValue">{{ _('Nội dung SEO') }}</label>
					<textarea name="metaValue" placeholder="{{ _('Nhậo nội dung SEO') }}" class="form-control">{{ $value }}</textarea>
				</div>
				<div class="group-action">
					<a href="{{ route('deletePageAdmin',['id'=>$page->id]) }}" class="btn btn-delete">{{ _('Xoá') }}</a>
					<button type="submit" class="btn">{{ _('Lưu') }}</button>
					<a href="{{ route('pagesAdmin') }}" class="btn btn-cancel">{{ _('Huỷ') }}</a>
				</div>
			</form>
		</div>
		<script type="text/javascript">
			ckeditor("editor");
			$(document).ready(function(){
				$("#edit-page .group-action button").click(function(){
					var _token = $(".edit-post input[name='_token']").val();
					var link = $('.dev-form').attr('action');
					var title = $(".edit-post #post-title input").val();
					var content = CKEDITOR.instances['editor'].getData();
					var metaKey = $("#frm-metaKey input").val();
					var metaValue = $("#frm-metaValue textarea").val();
					var metaFields = new Array();
					var count = 0;
					var errors = new Array();
					var error_count = 0;
					$("#fields .item").each(function(){
						var meta = "meta_"+$(this).attr("id");
						var type = $(this).find("meta-value").attr("data-type"); 
						var content = "";
						if(type == "editor"){
							content = CKEDITOR.instances[meta].getData();
						}else{
							content = $(this).find(".meta-value").val();
						}
						metaFields[count] = {
							'id' : $(this).attr("id"),
							'content' : content
						}
						count = count + 1;
					});				
					if(title=="") errors.push('Vui lòng nhập tên trang!');
					if(content=="") errors.push('Vui lòng nhập nội dùng trang');
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
								'metaValue': metaValue,
								'metaFields': JSON.stringify(metaFields)
							},
							success:function(data){
								if(data=="success"){
									$('#overlay').hide();
									$('.loading').hide();
									new PNotify({
										title: 'Success',
										text: 'Update page success!',
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
			//delete location
			// $(".dev-form .btn-delete").click(function(){
			// 	var href = $(this).attr("href");
			// 	(new PNotify({
			// 		title: 'Xoá',
			// 		text: 'Bạn muốn xoá trang này?',
			// 		icon: 'glyphicon glyphicon-question-sign',
			// 		type: 'error',
			// 		hide: false,
			// 		confirm: {
			// 			confirm: true
			// 		},
			// 		buttons: {
			// 			closer: false,
			// 			sticker: false
			// 		},
			// 		history: {
			// 			history: false
			// 		}
			// 	})).get().on('pnotify.confirm', function() { 
			// 		window.location.href = href;
			// 	});
			// 	return false;
			// });
		});
	</script>
@endsection