@extends('backend.layout.index')
@section('title','Thêm ảnh')
@section('content')
<?php $mediaCats = getMediaCats();?>
<div id="create-media" class="page">
	<div class="head">
		<a href="{{ route('media') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ _('Tất cả') }}</a>
		<h1 class="title">{{ _('Thêm ảnh') }}</h1>
	</div>
	<div id="dropzone">	
		<div class="row">
			<div class="col-md-3 sidebar clearfix">
				<section id="sb-image-of" class="box-wrap">
					<h2 class="title">{{ _('Ảnh của') }}</h2>
					<div class="gr-radio flex-list center-item">
                        <input class="gender" type="hidden" tabindex="-1" value="1">
                        <div class="radio radio-primary radio-inline">
                            <input type="radio" name="radio" id="image_of1" value="system" checked>
                            <label for="image_of1">{{ _('Hệ thống') }}</label>
                        </div>
                        <div class="radio radio-primary radio-inline">
                            <input type="radio" name="radio" id="image_of2" value="comic">
                            <label for="image_of2">{{ _('Truyện') }}</label>
                        </div>
                    </div>
				</section>
				<section id="sb-mediaCat" class="box-wrap">
					<h2 class="title">{{ _('Danh mục') }}</h2>
					@if(isset($mediaCats))
					<div class="desc list">
						@foreach($mediaCats as $item)
						<div class="checkbox checkbox-success item">
							<input id="item-{{ $item->id }}" type="checkbox" name="mediaCats[]" value="{{ $item->id }}">
							<label for="item-{{ $item->id }}">{{ $item->title }}</label>
						</div>
						@endforeach
					</div>
					@endif
				</section>
			</div>
			<div class="col-md-9 content clearfix">
				<form id="frmTarget" action="{{ route('storeMedia') }}" class="dropzone">
					{{ csrf_field() }}
					<input type="hidden" name="category" id="category" value="">
					<input type="hidden" name="image_of" value="">
					<div class="dz-message needsclick">{{ _('Thả file ảnh ở đây hoặc bấm vào để tải lên.') }}</div>
				</form>
				<div class="group-action">
					<button id="submit" type="submit" name="submit" class="btn">{{ _('Thêm') }}</button>
					<a href="{{ route('media') }}" class="btn btn-cancel">{{ _('Huỷ') }}</a>
				</div>
			</div>
		</div>
	</div>
</div>
	<script>
		$(document).ready(function(){
			var link = $("form").attr('action');
			Dropzone.options.frmTarget = {
				autoProcessQueue: false,
				// uploadMultiple: true,
				parallelUploads: 100,
				maxFiles:100,
				url: link,
				init: function () {
					var myDropzone = this;
					// Update selector to match your button
					$("#dropzone button").click(function (e) {
						e.preventDefault();
						var cat_ids = new Array();
						$("#sb-mediaCat .checkbox").each(function(){
							if($(this).find("input").is(":checked")){
								cat_ids.push($(this).find("input").val());
							}
						});
						$("#category").val(cat_ids.toString());
						//add image_of value
						$('input[name=image_of]').val($('input[name=radio]:checked').val());
						myDropzone.processQueue();
					});

					this.on('sending', function(file, xhr, formData) {
						var data = $('#frmTarget').serializeArray();
						var category = $("#category").val();
						formData.append('category', name);
						$.each(data, function(key, el) {
							formData.append(el.name, el.value);
						});
					});
					this.on("complete", function(file) { 
						myDropzone.removeFile(file);
					});
				},
				success: function(file, response){
	            }
			}	

		});
	</script>
@endsection