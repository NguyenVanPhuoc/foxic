@extends('backend.layout.index')
@section('title','Thêm danh mục')
@section('content')
	<div id="create-catComic" class="container catProduct-page product-page route">
		<div class="head">
			<a href="{{ route('catComicsAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ _('Tất cả') }}</a>
			<h1 class="title">{{ _('Thêm danh mục') }}</h1>
		</div>
		<div class="main">
			<form action="{{ route('storeCatComicAdmin') }}" class="dev-form activity-form" method="POST" name="create_catProduct" role="form">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="title">{{ _('Tên danh mục') }}<small class="required">(*)</small></label>
					<input type="text" name="title" class="form-control" placeholder="Input title">
				</div>
				<div id="frm-metaKey" class="form-group">
					<label for="metakey">{{ _('Từ khoá (SEO)') }}</label>
					<input type="text" name="meta_key" class="form-control"  placeholder="Nhập từ khoá (SEO)">
				</div>
				<div id="frm-metaValue" class="form-group">
					<label class="metaValue">{{ _('Mô tả meta (SEO) 150-160 ký tự') }}</label>
					<span class="count-characters"></span>
					<textarea name="meta_value" placeholder="Nhập mô tả meta (SEO) 150-160 ký tự" class="form-control"></textarea>
				</div>
				<div class="form-group">
					<label class="metaValue">{{ _('Mô tả') }}</label>
					<span class="count-characters"></span>
					<textarea name="desc"  class="form-control"></textarea>
				</div>
				<div class="row">
					<div class="col-md-3">
						<div id="frm-image" class="form-group img-upload">
							<label for="name">{{ _('Ảnh đại diện') }}</label>
							<div class="image">
								<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
								{!! image('',150,150,'Ảnh đại diện') !!}
								<input type="hidden" name="image" class="thumb-media" value="">
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div id="frm-icon" class="form-group img-upload">
							<label for="name">{{ _('Icon') }}</label>
							<div class="image">
								<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
								{!! image('',150,150,'Icon') !!}
								<input type="hidden" name="icon" class="thumb-media" value="">
							</div>
						</div>
					</div>
				</div>
				
				<div class="group-action">
					<button type="submit" name="submit" class="btn">{{ _('Lưu') }}</button>
					<a href="{{ route('catComicsAdmin') }}" class="btn btn-cancel">{{ _('Huỷ') }}</a>
				</div>
			</form>
		</div>
	</div>
	@include('backend.media.library')
@endsection