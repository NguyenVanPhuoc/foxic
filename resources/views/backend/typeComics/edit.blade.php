@php
	$seo = get_seo($typeComic->id, 'type_comic');
	$meta_key = $meta_value = '';
	if($seo){
		$meta_key = $seo->key;
		$meta_value = $seo->value;
	}
@endphp

@extends('backend.layout.index')
@section('title','Sửa thể loại')
{{-- @section('css')
	<link rel="stylesheet" href="{{asset('public/admin/css/bootstrap-colorpicker.min.css')}}">
@endsection
@section('js')
	<script src="{{ asset('public/admin/js/bootstrap-colorpicker.min.js') }}" type="text/javascript"></script>
@endsection --}}
@section('content')
	<div id="edit-typeComic" class="container catProduct-page product-page route">
		<div class="head">
			<a href="{{ route('typeComicsAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ _('Tất cả') }}</a>
			<h1 class="title">{{ _('Sửa thể loại') }}</h1>
			<a href="{{ route('createTypeComicAdmin') }}" class="btn btn-add">{{ _('Thêm mới') }}</a>
		</div>
		<div class="main">
			<form action="{{ route('updateTypeComicAdmin', $typeComic->id) }}" class="dev-form activity-form" method="POST" name="create_catProduct" role="form">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="title">{{ _('Tên thể loại') }}<small class="required">(*)</small></label>
					<input type="text" name="title" class="form-control" placeholder="Input title" value="{{ $typeComic->showTitle() }}">
				</div>
				{{-- <div id="frm-color" class="form-group">
					<label>Color</label>
					<div id="color" class="input-group colorpicker-component">
					    <input type="text" name="color" class="form-control" placeholder="Input color code or chosen (Exmple code: #fffff, #ff0000,...)" value="{{ $typeComic->color }}" />
					    <span class="input-group-addon"><i></i></span>
					</div>	
				</div>	 --}}
				<div id="frm-desc" class="form-group">
					<label for="desc">{{ _('Mô tả thể loại') }}</label>
					<textarea name="desc" id="desc" class="form-control">{{ $typeComic->desc }}</textarea>
				</div>
				<div id="frm-metaKey" class="form-group">
					<label for="metakey">{{ _('Từ khoá (SEO)') }}</label>
					<input type="text" name="meta_key" class="form-control" placeholder="Nhập từ khoá(SEO)" value="{{ $meta_key }}">
				</div>
				<div id="frm-metaValue" class="form-group">
					<label class="metaValue">{{ _('Mô tả meta (SEO) 150-160 ký tự') }}</label>
					<span class="count-characters">( {{ strlen($meta_value) }} {{ _('ký tự') }} )</span>
					<textarea name="meta_value" placeholder="Nhập mô tả ký tự(SEO) 150-160 characters" class="form-control">{{ $meta_value }}</textarea>
				</div>
				
				<div class="group-action">
					<a href="{{ route('deleteTypeComicAdmin', $typeComic->id) }}" class="btn btn-delete">{{ _('Xoá') }}</a>
					<button type="submit" name="submit" class="btn">{{ _('Cập nhật') }}</button>
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