@extends('backend.layout.index')
@section('title','Thêm thể loại')
{{-- @section('css')
	<link rel="stylesheet" href="{{asset('public/admin/css/bootstrap-colorpicker.min.css')}}">
@endsection --}}
{{-- @section('js')
	<script src="{{ asset('public/admin/js/bootstrap-colorpicker.min.js') }}" type="text/javascript"></script>
@endsection --}}

@section('content')
	<div id="create-typeComic" class="container catProduct-page product-page route">
		<div class="head">
			<a href="{{ route('typeComicsAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ _('Tất cả') }}</a>
			<h1 class="title">{{ _('Thêm thể loại') }}</h1>
		</div>
		<div class="main">
			<form action="{{ route('storeTypeComicAdmin') }}" class="dev-form activity-form" method="POST" name="create_catProduct" role="form">
				{{ csrf_field() }}
				<div id="frm-title" class="form-group">
					<label for="title">{{ _('Tên thể loại') }}<small class="required">(*)</small></label>
					<input type="text" name="title" class="form-control" placeholder="{{ _('Nhập tên thể loại') }}">
				</div>
				{{-- <div id="frm-color" class="form-group">
					<label>Color</label>
					<div id="color" class="input-group colorpicker-component">
					    <input type="text" name="color" value="" class="form-control" placeholder="Input color code or chosen (Exmple code: #fffff, #ff0000,...)" />
					    <span class="input-group-addon"><i></i></span>
					</div>	
				</div>	 --}}
				<div id="frm-desc" class="form-group">
					<label for="desc">{{ _('Mô tả thể loại') }}</label>
					<textarea name="desc" id="desc" class="form-control"></textarea>
				</div>
				<div id="frm-metaKey" class="form-group">
					<label for="metakey">{{ _('Từ khoá (SEO)') }}</label>
					<input type="text" name="meta_key" class="form-control"  placeholder="{{ _('Nhập từ khoá (SEO)') }}">
				</div>
				<div id="frm-metaValue" class="form-group">
					<label class="metaValue">{{ _('Mô tả meta (SEO) 150-160 ký tự') }}</label>
					<span class="count-characters"></span>
					<textarea name="meta_value" placeholder="Nhập mô tả meta (SEO) 150-160 ký tự" class="form-control"></textarea>
				</div>
				
				<div class="group-action">
					<button type="submit" name="submit" class="btn">{{ _('Lưu') }}</button>
					<a href="{{ route('typeComicsAdmin') }}" class="btn btn-cancel">{{ _('Huỷ') }}</a>
				</div>
			</form>
		</div>
	</div>
	@include('backend.media.library')
	<script type="text/javascript">
		ckeditor("desc");
	</script>
@endsection