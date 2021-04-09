@php
	$seo = get_seo($catComic->id, 'category_comic');
	$meta_key = $meta_value = '';
	if($seo){
		$meta_key = $seo->key;
		$meta_value = $seo->value;
	}
@endphp
@extends('backend.layout.index')
@section('title','Sửa danh mục')
@section('content')
	<div id="edit-catComic" class="container catProduct-page product-page route">
		<div class="head">
			<a href="{{ route('catComicsAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ _('Tất cả') }}</a>
			<h1 class="title">{{ _('Sửa danh mục') }}</h1>
			<a href="{{ route('createCatComicAdmin') }}" class="btn btn-add">{{ _('Thêm') }}</a>
		</div>
		<div class="main">
			<form action="{{ route('updateCatComicAdmin', $catComic->id) }}" class="dev-form activity-form" method="POST" name="create_catProduct" role="form">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="title">{{ _('Tên danh mục') }}<small class="required">(*)</small></label>
					<input type="text" name="title" class="form-control" placeholder="Input title" value="{{ $catComic->showTitle() }}">
				</div>
				<div id="frm-metaKey" class="form-group">
					<label for="metakey">{{ _('Từ khoá (SEO)') }}</label>
					<input type="text" name="meta_key" class="form-control" placeholder="Nhập từ khoá (SEO)" value="{{ $meta_key }}">
				</div>
				<div id="frm-metaValue" class="form-group">
					<label class="metaValue">{{ _('Mô tả meta (SEO) 150-160 ký tự') }}</label>
					<span class="count-characters">( {{ strlen($meta_value) }} {{ _('ký tự') }} )</span>
					<textarea name="meta_value" placeholder="Nhập mô tả meta (SEO) 150-160 ký tự" class="form-control">{{ $meta_value }}</textarea>
				</div>
				<div class="form-group">
					<label class="metaValue">{{ _('Mô tả') }}</label>
					<span class="count-characters"></span>
					<textarea name="desc"  class="form-control">{{ $catComic->desc }}</textarea>
				</div>
				<div class="row">
					<div class="col-md-3">
						<div id="frm-image" class="form-group img-upload">
							<label for="name">{{ _('Ảnh đại diện') }}</label>
							<div class="image">
								<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
								{!! image($catComic->image,150,150,'Ảnh đại diện') !!}
								<input type="hidden" name="image" class="thumb-media" value="{{ $catComic->image }}" />
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div id="frm-icon" class="form-group img-upload">
							<label for="name">{{ _('Icon') }}</label>
							<div class="image">
								<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
								{!! image($catComic->icon,150,150,'Icon') !!}
								<input type="hidden" name="icon" class="thumb-media" value="{{ $catComic->icon }}" />
							</div>
						</div>
					</div>
				</div>
				
				<div class="group-action">
					<button type="submit" name="submit" class="btn">{{ _('Cập nhật') }}</button>
					<a href="{{ route('catComicsAdmin') }}" class="btn btn-cancel">{{ _('Huỷ') }}</a>
				</div>
			</form>
		</div>
	</div>
	@include('backend.media.library')
@endsection