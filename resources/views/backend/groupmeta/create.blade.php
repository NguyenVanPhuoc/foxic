@extends('backend.layout.index')
@section('title','Add group')
@section('content')
	<div id="create-mediaField" class="container page media-fields">
		<div class="head"><h1 class="title">{{ _('Add group') }}</h1></div>
		{{-- @if(count($errors)>0)
		<div class="alert alert-danger">
			<ul>
				@foreach($errors->all() as $error)
				<li>{{ $error }}</li>	
				@endforeach
			</ul>
		</div>
		@endif --}}
		<div class="notify"></div>
		<form id="add-groupMeta" action="{{ route('storeMeta') }}" method="post" name="groupMeta" class="dev-form groupMeta add-post">
			{{ csrf_field() }}
			<div id="groupMeta-fields" class="row">
				<div id="frm-title" class="form-group col-md-8">
					<label for="title">{{ _('Name group') }}<small>(*)</small></label>
					<input type="text" name="title" class="form-control title" value="{{ old('title') }}" />
				</div>
				@if($pages != null)
					<div id="frm-object" class="form-group col-md-4">
						<label for="object">{{ _('Apply') }}<small>(*)</small></label>	
						<select class="form-control" name="object">
							@foreach($pages as $page)
								<option value="{{ $page->id }}" data-value="{{ $page->slug }}">{{ $page->title }}</option>
							@endforeach
						</select>
					</div>
				@endif
			</div>
			<div id="fields" class="meta"></div>
			<a href="#" class="add-field">{{ _('Add field') }}</a>
			<div class="group-action">
				<button type="submit" class="btn">{{ _('Save') }}</button>
				<a href="{{ route('metas') }}" class="btn btn-cancel">{{ _('Return') }}</a>
			</div>
		</form>
	</div>
	<script>
		$(document).ready(function(){
			$(".add-field").click(function(){
				var html = '<div class="item row">';
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
			$( document ).on( "click", "#fields a.btn", function() {
				$(this).parents(".item").remove();
				return false;
			});

			//add group meta
			$("#add-groupMeta .group-action button").click(function(){
				$(".notify").html();
				var _token = $("form input[name='_token']").val();
				var link = $("form").attr('action');
				var title = $("#frm-title .title").val();
				var object = $("#frm-object select").val();
				var metas = new Array();
				var count = 0;
				var errors = new Array();
				var error_count = 0;
				$("#fields .item").each(function(){
					var metaName = $(this).find(".meta-name").val();
					if( metaName != ""){
						metas[count] = {
							'title' : $(this).find(".meta-name").val(),
							'type' : $(this).find(".type").val(),
							'width' : $(this).find(".column").val()
						}
						count = count + 1;
					}else{
						error_count += 1;
					}
					
				});
				if(title=="") errors.push("Please enter field title");
				if(metas.length == 0) errors.push("One / more rows have not entered the field name");
				var i;
				var html = "<ul>";
				for(i = 0; i < errors.length; i++){
					if(errors[i] != ""){
						html +='<li>'+errors[i]+'</li>';
						error_count += 1;
					}
				}     
				var metaJson= JSON.stringify(metas);
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
							'object': object,
							'metas': metaJson,
						},
						success:function(data){
							if(data != "errors"){
								$('#overlay').hide();
								$('.loading').hide();
								new PNotify({
									title: 'Thành công',
									text: 'Thêm thành công.',
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
						}
					});
				}
				return false;
			});
		})
	</script>
@endsection