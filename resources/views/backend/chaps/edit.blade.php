@extends('backend.layout.index')
@section('title','Sửa chương')
@section('content')
@section('js')
	<script src="{{ asset('public/admin/js/comic.js') }}" type="text/javascript"></script> 
@endsection
@php
	$seo = get_seo($chap->id, 'chap');
	$meta_key = $meta_value = '';
	if($seo){
		$meta_key = $seo->key;
		$meta_value = $seo->value;
	}
	$list_content = json_decode($chap->content);
	$status=get_statusComic();
@endphp
	<div id="create-comic" class="container catProduct-page product-page route">
		<div class="head">
			<a href="{{ route('chapsAdmin',[$comic->id, $book->id]) }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ __('Tất cả chương của') }} {{ $book->title }}</a>
			<h1 class="title">{{ __('Sửa chương') }} {{ $chap->title }} of {{ $book->title }}</h1>
		</div>
		<div class="main">
			<form action="{{ route('updateChapAdmin', [$comic->id, $book->id, $chap->id]) }}" class="dev-form activity-form" method="POST" role="form">
				{{ csrf_field() }}
				<div class="row">
					<div class="col-md-9 content">
						<div class="row">
							<div id="frm-chap" class="form-group col-md-6">
								<label for="chap">{{ __('Chương') }}<small class="required">(*)</small></label>
								<input type="text" name="chap" class="form-control" placeholder="Nhập chương" value="{{ $chap->chap }}" disabled>
							</div>
							<div id="frm-short_chap" class="form-group col-md-6">
								<label for="short_chap">{{ __('Chương rút gọn') }}<small class="required">(*)</small></label>
								<input type="text" name="short_chap" class="form-control" placeholder="Nhập chương rút gọn" value="{{ $chap->short_chap }}" disabled> 
							</div>
						</div>
						<div id="frm-tilte" class="form-group">
							<label for="title">{{ __('Tên chương') }}<small class="required">(*)</small></label>
							<input type="text" name="title" class="form-control" placeholder="Nhập tên chương" value="{{ $chap->title }}">
						</div>
						<div id="frm-content_chap" class="form-group">
							<label for="content_chap">{{ __('Nội dung chương') }}<small class="required">(*)</small></label>
							<textarea name="content" id="content_chap" class="form-control">{{ $chap->content }}</textarea>
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
						<div id="frm-rental" class="form-group">
							<label for="rental">{{ _('Nhập số phiếu thuê') }}</label>
							<input name="rental" placeholder="Nhập số phiếu thuê" class="form-control" value="{{ $chap->rental }}"></input>
						</div>
						<div id="frm-point" class="form-group">
							<label for="metakey">{{ _('Nhập số point mua') }}</label>
							<input name="point" placeholder="Nhập số point mua" class="form-control" value="{{ $chap->point }}"></input>
						</div>
					</div>
					<div class="col-md-3 sidebar">
						@can('comics.publish')
							<section id="sb-status" class="box-wrap">
								<h2 class="title">{{ _('Status') }}</h2>
								<div id="frm-status"  class="form-group">
									<select class="select2" name="status">
										<option value="">{{ __('Chọn trạng thái') }}</option>
										@foreach ($status as $key => $item)
											<option value="{{ $key }}" {{ $chap->status == $key ? 'selected' : ''}}>{{ $item }}</option>
										@endforeach
									</select>
								</div>
							</section>
						@endcan
					</div>
					<div class="group-action">
						<a href="{{ route('deleteChapAdmin', ['comic_id'=>$comic->id, 'book_id'=>$book->id, 'id'=>$chap->id]) }}" class="btn btn-delete" title="delete">{{ __('Xoá chap') }}</a>
						<button type="submit" name="submit" class="btn">{{ __('Cập nhật') }}</button>
						<a href="{{ route('chapsAdmin',[$comic->id, $book->id]) }}" class="btn btn-cancel">{{ __('Huỷ') }}</a>	
					</div>
				</div>
			</form>
		</div>
	</div>
	@include('backend.media.library')
	<script type="text/javascript">
		ckeditor("content_chap");
	</script>
@endsection
