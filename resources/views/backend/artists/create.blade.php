@extends('backend.layout.index')
@section('title','Thêm họa sĩ')
@section('content')
	<div id="create-writer" class="container catProduct-page product-page route">
		<div class="head">
			<a href="{{ route('artistsAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ _('Tất cả') }}</a>
			<h1 class="title">{{ _('Thêm họa sĩ') }}</h1>
		</div>
		<div class="main">
			<form action="{{ route('storeArtistAdmin') }}" class="dev-form activity-form" method="POST" name="create_writer" role="form">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="title">{{ _('Tên họa sĩ') }}<small class="required">(*)</small></label>
					<input type="text" name="title" class="form-control" placeholder="Nhập tên tác giả">
				</div>
				<div id="frm-metaKey" class="form-group">
					<label for="metakey">{{ __('Từ khoá (SEO)') }}</label>
					<input type="text" name="meta_key" class="form-control"  placeholder="Nhập từ khoá (SEO)" value="">
				</div>
				<div id="frm-metaValue" class="form-group">
					<label class="metaValue">{{ __('Mô tả meta (SEO) 150-160 ký tự') }}</label>
					<span class="count-characters"></span>
					<textarea name="meta_value" placeholder="Nhập mô tả meta (SEO) 150-160 characters" class="form-control"></textarea>
				</div>
				<div class="group-action">
					<button type="submit" name="submit" class="btn">{{ _('Lưu') }}</button>
					<a href="{{ route('artistsAdmin') }}" class="btn btn-cancel">{{ _('Hủy') }}</a>
				</div>
			</form>
		</div>
	</div>
@endsection