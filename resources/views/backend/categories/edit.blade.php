@php
	$seo = get_seo($cate->id, 'category');
	$meta_key = $meta_value = '';
	if($seo){
		$meta_key = $seo->key;
		$meta_value = $seo->value;
	}
@endphp
@extends('backend.layout.index')
@section('title','Sửa danh mục')
@section('content')
	<div id="edit-cate" class="container route">
		<div class="head">
			<a href="{{ route('categoriesAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ __('Tất cả') }}</a>
			<h1 class="title">{{ __('Sửa danh mục') }}</h1>
		</div>
		<div class="main">
			<form action="{{ route('updateCategoryAdmin', $cate->id) }}" class="dev-form activity-form" method="POST" name="create_catProduct" role="form">
				{{ csrf_field() }}
				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<label for="title">{{ __('Tên danh mục') }}<small class="required">(*)</small></label>
							<input type="text" name="title" class="form-control" placeholder="Input title" value="{{ $cate->title }}">
						</div>
						<div class="form-group">
							<label class="metaValue">{{ __('Mô tả') }}</label>
							<span class="count-characters"></span>
							<textarea name="content" class="form-control">{{ $cate->content }}</textarea>
						</div>
						<div id="frm-metaKey" class="form-group">
							<label for="metakey">{{ __('Từ khoá (SEO)') }}</label>
							<input type="text" name="meta_key" class="form-control" placeholder="Nhập từ khoá (SEO)" value="{{ $meta_key }}">
						</div>
						<div id="frm-metaValue" class="form-group">
							<label class="metaValue">{{ __('Mô tả meta (SEO) 150-160 ký tự') }}</label>
							<span class="count-characters">( {{ strlen($meta_value) }} {{ __('ký tự') }} )</span>
							<textarea name="meta_value" placeholder="Nhập mô tả meta (SEO) 150-160 ký tự" class="form-control">{{ $meta_value }}</textarea>
						</div>
						<div class="group-action">
							<button type="submit" name="submit" class="btn">{{ __('Cập nhật') }}</button>
							<a href="{{ route('categoriesAdmin') }}" class="btn btn-cancel">{{ __('Huỷ') }}</a>
						</div>
					</div>
					<div class="col-md-3 sidebar">
						<section id="sb-image" class="box-wrap">
							<h3 class="title">Ảnh đại diện</h3>
							<div id="frm-image" class="form-group img-upload">
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!! image($cate->image,150,150,'Ảnh đại diện') !!}
								<input type="hidden" name="image" class="thumb-media" value="{{ $cate->image }}" />
								</div>
							</div>
						</section>
					</div>
				</div>						
			</form>
		</div>
	</div>
	@include('backend.media.library')
@endsection