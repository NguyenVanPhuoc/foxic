@extends('backend.layout.index')
@section('title','Sửa họa sĩ')
@section('content')
	@php
		$seo = get_seo($artist->id, 'comic_artist');
		$meta_key = $meta_value = '';
		if($seo){
			$meta_key = $seo->key;
			$meta_value = $seo->value;
		}
	@endphp
	<div id="create-writer" class="container catProduct-page product-page route">
		<div class="head">
			<a href="{{ route('artistsAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ _('Tất cả') }}</a>
			<h1 class="title">{{ _('Sửa họa sĩ') }}</h1>
		</div>
		<div class="main">
			<form action="{{ route('updateArtistAdmin', $artist->id) }}" class="dev-form activity-form" method="POST" name="create_writer" role="form">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="title">{{ _('Tên họa sĩ') }}<small class="required">(*)</small></label>
					<input type="text" name="title" class="form-control" placeholder="Nhập tên giác" value="{{ $artist->show_name() }}">
				</div>
				<div id="frm-metaKey" class="form-group">
					<label for="metakey">{{ __('Từ khoá (SEO)') }}</label>
					<input type="text" name="meta_key" class="form-control"  placeholder="Nhập từ khoá (SEO)" value="{{ $meta_key }}">
				</div>
				<div id="frm-metaValue" class="form-group">
					<label class="metaValue">{{ __('Mô tả meta (SEO) 150-160 ký tự') }}</label>
					<span class="count-characters">({{ strlen($meta_value) }} {{ __('ký tự') }})</span>
					<textarea name="meta_value" placeholder="Nhập mô tả meta (SEO) 150-160 characters" class="form-control">{{ $meta_value }}</textarea>
				</div>
				<div class="group-action">
					<button type="submit" name="submit" class="btn">{{ _('Cập nhật') }}</button>
					<a href="{{ route('artistsAdmin') }}" class="btn btn-cancel">{{ _('Huỷ') }}</a>
				</div>
			</form>
		</div>
	</div>
@endsection