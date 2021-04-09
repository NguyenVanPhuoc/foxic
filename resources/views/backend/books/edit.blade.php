@extends('backend.layout.index')
@section('title','Sửa chương')
@section('content')
@section('js')
	<script src="{{ asset('public/admin/js/comic.js') }}" type="text/javascript"></script> 
@endsection
@php
	$seo = get_seo($book->id, 'book');
	$meta_key = $meta_value = '';
	if($seo){
		$meta_key = $seo->key;
		$meta_value = $seo->value;
	}
@endphp
	<div id="create-comic" class="container catProduct-page product-page route">
		<div class="head">
			<a href="{{ route('booksAdmin', $comic->id) }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ __('Tất cả quyển của') }} {{ $comic->title }}</a>
			<h1 class="title">{{ __('Sửa quyển') }} {{ $book->title }} of {{ $comic->title }}</h1>
		</div>
		<div class="main">
			<form action="{{ route('updateBookAdmin', [$comic->id, $book->id]) }}" class="dev-form activity-form" method="POST" role="form">
				{{ csrf_field() }}
				<div class="row">
					<div class="col-md-9 content">
						<div id="frm-tilte" class="form-group">
							<label for="title">{{ __('Tên quyển') }}<small class="required">(*)</small></label>
							<input type="text" name="title" class="form-control" placeholder="Nhập tên quyển" value="{{ $book->title }}">
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
							<a href="{{ route('deleteBookAdmin', ['comic_id'=>$comic->id, 'id'=>$book->id]) }}" class="btn btn-delete" title="delete">{{ __('Xoá chap') }}</a>
							<button type="submit" name="submit" class="btn">{{ __('Cập nhật') }}</button>
							<a href="{{ route('booksAdmin', $comic->id) }}" class="btn btn-cancel">{{ __('Huỷ') }}</a>	
						</div>
					</div>
					<div class="col-md-3 sidebar">
						<section id="sb-image" class="box-wrap">
							<h2 class="title">{{ _('Image') }}</h2>
							<div id="frm-image"  class="form-group img-upload">
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!! image($book->image,150,150,'Image') !!}
									<input type="hidden" name="image" class="thumb-media" value="{{ $book->image }}">
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
