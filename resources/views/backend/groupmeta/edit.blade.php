@extends('backend.layout.index')
@section('title','Edit group')
@section('content')
	<div id="edit-mediaField" class="container page media-fields">
		<div class="head"><h1 class="title">{{ _('Group ').$groupMeta->title }}</h1></div>
		<form action="{{ route('updateMeta',['id'=>$groupMeta->id]) }}" method="post" name="groupMeta" class="dev-form groupMeta edit-post">
			{{ csrf_field() }}
			<div id="groupMeta-fields" class="row">
				<div class="form-group col-md-8" id="title">
					<label for="title">{{ _('') }}<small>(*)</small></label>
					<input type="text" name="title" class="form-control title" value="{{ $groupMeta->title }}">
				</div>
				@if($pages != null)
					<div class="form-group col-md-4" id="object">
						<label for="object">{{ _('Apply') }}<small>(*)</small></label>
						<select class="form-control" name="object">
							@foreach($pages as $page)
							<option value="{{ $page->id }}"@if($groupMeta->post_id == $page->id) selected @endif>{{ $page->title }}</option>
							@endforeach
						</select>
					</div>
				@endif
			</div>
			<div id="fields" class="meta">
				@foreach($metas as $meta)
				<div id="meta-{{ $meta->id }}" class="item row edit">
					<div class="form-group col-md-6">
						<label for="">{{ _('Name field') }}<small>(*)</small></label>
						<input type="text" name="{{ $meta->slug }}" class="form-control meta-name" value="{{ $meta->title }}" />
					</div>
					<div class="form-group col-md-3">
						<label for="type">{{ _('Type') }}<small>(*)</small></label>
						<select class="form-control type" name="type">
							<option value="text" @if($meta->type == 'text') selected @endif>Text</option>
							<option value="textarea" @if($meta->type == 'textarea') selected @endif>Textarea</option>
							<option value="editor" @if($meta->type == 'editor') selected @endif>Editor</option>
						</select>
					</div>
					<div class="form-group col-md-2">
						<label for="column">{{ _('Width') }}<small>(*)</small></label>
						<select class="form-control column" name="column">
							<option value="2"@if($meta->width == 2) selected @endif>20%</option>
							<option value="3"@if($meta->width == 3) selected @endif>25%</option>
							<option value="4"@if($meta->width == 4) selected @endif>33%</option>
							<option value="6"@if($meta->width == 6) selected @endif>50%</option>
							<option value="9"@if($meta->width == 9) selected @endif>75%</option>
							<option value="12"@if($meta->width == 12) selected @endif>100%</option>
						</select>
					</div>
					<div class="form-group col-md-1">
						<a href="#{{ $meta->id }}" id="{{ $meta->id }}" class="btn delete">{{ _('Delete') }}</a>
					</div>
				</div>
				@endforeach

			</div>
			<a href="#" class="add-field">{{ _('Add field') }}</a>
			<div class="group-action">
				<button type="submit" class="btn">{{ _('Edit') }}</button>
				<a href="{{ route('metas') }}" class="btn btn-cancel">{{ _('Return') }}</a>
			</div>
		</form>
	</div>
	<script>
		$(document).ready(function(){
			$(".add-field").click(function(){
				var html = '<div class="item row add">';
				html = html + '<div class="form-group col-md-6">';
				html = html + '<label for="meta_name">Name field<small>(*)</small></label>';
				html = html + '<input type="text" name="meta_name" class="form-control meta-name"/>';
				html = html + '</div>';
				html = html + '<div class="form-group col-md-3">';
				html = html + '<label for="type">Type<small>(*)</small></label>';
				html = html + '<select class="form-control type" name="type">';
				html = html + '<option value="text">Text</option>';
				html = html + '<option value="textarea">Textarea</option>';
				html = html + '<option value="editor">Editor</option>';
				html = html + '</select>';
				html = html + '</div>';
				html = html + '<div class="form-group col-md-2">';
				html = html + '<label for="column">Width<small>(*)</small></label>';
				html = html + '<select class="form-control column" name="column">';
				html = html + '<option value="2">20%</option>';
				html = html + '<option value="3">25%</option>';
				html = html + '<option value="4">33%</option>';
				html = html + '<option value="6">50%</option>';
				html = html + '<option value="12">100%</option>';
				html = html + '</select>';
				html = html + '</div>';
				html = html + '<div class="form-group col-md-1">';
				html = html + '<a href="#" class="btn">Delete</a>';
				html = html + '</div';
				html = html + '</div';
				$("#fields").append(html);
				return false;
			});

			//remve item
			$( document ).on( "click", "#fields .add a.btn", function() {
				$(this).parents(".item").remove();
				return false;
			});

			var delItems = new Array();
			$(".edit-post").on('click','#fields .edit .delete',function(){
				var metaId = $(this).attr("id");
				delItems.push(metaId);
				$(this).parents("#meta-"+metaId).remove();
			});
			//edit group meta
			$(".edit-post .group-action button").click(function(){	
				var _token = $(".edit-post input[name='_token']").val();
				var link = $(".edit-post").attr('action');
				var title = $(".edit-post #title .title").val();
				var object = $(".edit-post #object select").val();
				var editMetas = new Array();
				var addMetas = new Array();
				var errors = new Array();	
				var error_count = 0;
				var count = 0;
				$("#fields .edit").each(function(){
					editMetas[count] = {
						'id' : $(this).find(".delete").attr("id"),
						'title' : $(this).find(".meta-name").val(),
						'type' : $(this).find(".type").val(),
						'width' : $(this).find(".column").val()
					}
					count = count + 1;
				});
				var count = 0;
				$("#fields .add").each(function(){
					addMetas[count] = {
						'title' : $(this).find(".meta-name").val(),
						'type' : $(this).find(".type").val(),
						'width' : $(this).find(".column").val()
					}
					count = count + 1;
				});
				if(title=="") errors.push("Vui lòng nhập tiêu đề");
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
							'object': object,
							'editMetas': JSON.stringify(editMetas),
							'addMetas': JSON.stringify(addMetas),
							'delItems': JSON.stringify(delItems)
						},
						success:function(data){
							if(data=="success"){
								// delItems = new Array();
								new PNotify({
									title: 'Thành công',
									text: 'Cập nhật thành công.',
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
						}
					});
				}
				return false;
			});

			//delete meta
			$( document ).on( "click", "#fields .edit .delete", function() {
				var title = $(this).parents(".edit").find(".meta-name").val();
				var link = $(this).attr("href");
				var id = $(this).attr("id");
				$('.delete-modal-meta .modal-footer .btn-primary').attr("href",link);
				$('.delete-modal-meta .modal-footer .btn-primary').attr("id",id);
				$('.delete-modal-meta .modal-body p').html("Bạn chắc là muốn xóa <strong>"+title+" ?</strong>");
				$('.delete-modal-meta').modal('toggle');
				return false;
			});

			$( document ).on( "click", ".delete-modal-meta .btn-primary", function() {
				var _token = $(".edit-post input[name='_token']").val();
				var id = parseInt($(this).attr("id"));
				$.ajax({
					type:'POST',
					url: $(this).attr("href"),
					cache: false,
					data:{
						'_token': _token,
						'id': id
					},
					success:function(data){
						if(data=="success"){
							$("#fields #meta-"+id).remove();
							$(".delete-modal-meta").css({'display':'none'});
							$(".delete-modal-meta").removeClass("show");
							$(".modal-backdrop").remove();
						}
					}
				})
				return false;
			});
		})
	</script>
@endsection