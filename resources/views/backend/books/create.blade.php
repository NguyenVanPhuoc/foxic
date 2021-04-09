@section('js')
	<script src="{{ asset('public/admin/js/comic.js') }}" type="text/javascript"></script> 
@endsection
@extends('backend.layout.index')
@section('title','Thêm quyển')
@section('content')
	<div id="create-comic" class="container catProduct-page product-page route">
		<div class="head">
			<a href="{{ route('booksAdmin', $comic->id) }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ _('Tất cả quyển của') }} {{ $comic->title }}</a>
			<h1 class="title">{{ _('Thêm quyển của') }} {{ $comic->title }}</h1>
		</div>
		<div class="main">
			<form action="{{ route('storeBookAdmin', $comic->id) }}" class="dev-form activity-form" method="POST" role="form">
				{{ csrf_field() }}
				<div class="row">
					<div class="col-md-9 content">
						<div id="frm-tilte" class="form-group">
							<label for="title">{{ _('Tên quyển') }}<small class="required">(*)</small></label>
							<input type="text" name="title" class="form-control" placeholder="Nhập tên quyển">
						</div>
						<div id="frm-metaKey" class="form-group">
							<label for="metakey">{{ _('Tứ khoá (SEO)') }}</label>
							<input type="text" name="meta_key" class="form-control"  placeholder="Nhập từ khoá (SEO)">
						</div>
						<div id="frm-metaValue" class="form-group">
							<label class="metaValue">{{ _('Mô tả meta (SEO) 150-160 ký tự') }}</label>
							<span class="count-characters"></span>
							<textarea name="meta_value" placeholder="Nhập mô tả meta (SEO) 150-160 ký tự" class="form-control"></textarea>
						</div>
						<div class="group-action">
							<button type="submit" name="submit" class="btn">{{ _('Lưu') }}</button>
							<a href="{{ route('booksAdmin', $comic->id) }}" class="btn btn-cancel">{{ _('Huỷ') }}</a>
						</div>
					</div>
					<div class="col-md-3 sidebar">
						<section id="sb-image" class="box-wrap">
							<h2 class="title">{{ _('Image') }}</h2>
							<div id="frm-image"  class="form-group img-upload">
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!! image('',150,150,'Image') !!}
									<input type="hidden" name="image" class="thumb-media" value="">
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