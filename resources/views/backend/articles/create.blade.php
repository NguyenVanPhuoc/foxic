@extends('backend.layout.index')
@section('title','Thêm Bài viết')
@section('content')
	<div id="create-cat" class="container route">
		<div class="head">
			<a href="{{ route('articlesAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ __('Tất cả') }}</a>
			<h1 class="title">{{ __('Thêm Bài viết') }}</h1>
		</div>
		<div class="main">
			<form action="{{ route('storeArticleAdmin') }}" class="dev-form activity-form" method="POST" role="form">
				{{ csrf_field() }}
				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<label for="title">{{ __('Tên bài viết') }}<small class="required">(*)</small></label>
							<input type="text" name="title" class="form-control" placeholder="Tên bài viết" required>
						</div>
						<div class="form-group">
							<label>{{ __('Mô tả ngắn') }}</label>
							<span class="count-characters"></span>
							<textarea name="desc" class="form-control"></textarea>
						</div>
						<div class="form-group">
							<label>{{ __('Nội dung') }}</label>
							<span class="count-characters"></span>
							<textarea name="content" id="editor" class="form-control"></textarea>
						</div>
						<div id="frm-metaKey" class="form-group">
							<label for="metakey">{{ __('Từ khoá (SEO)') }}</label>
							<input type="text" name="meta_key" class="form-control"  placeholder="Nhập từ khoá (SEO)">
						</div>
						<div id="frm-metaValue" class="form-group">
							<label class="metaValue">{{ __('Mô tả meta (SEO) 150-160 ký tự') }}</label>
							<span class="count-characters"></span>
							<textarea name="meta_value" placeholder="Nhập mô tả meta (SEO) 150-160 ký tự" class="form-control"></textarea>
						</div>
						<div class="group-action">
							<button type="submit" name="submit" class="btn">{{ __('Lưu') }}</button>
							<a href="{{ route('articlesAdmin') }}" class="btn btn-cancel">{{ __('Huỷ') }}</a>
						</div>
					</div>
					<div class="col-md-3 sidebar">
						<section id="sb-image" class="box-wrap">
							<h3 class="title">Ảnh đại diện</h3>
							<div id="frm-image" class="form-group img-upload">
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!! image('',150,150,'Ảnh đại diện') !!}
									<input type="hidden" name="image" class="thumb-media" value="">
								</div>
							</div>
						</section>
						<section id="sb-cate" class="box-wrap">
							<h2 class="title">{{ __('Danh mục') }}<small class="required">(*)</small></h2>
							<div class="form-group">
								<select name="cate_id[]" class="form-control select2 multiple" multiple required>
									<option value="" disabled >Chọn danh mục</option>
									{!! display_categoies_option() !!}
								</select>
							</div>
						</section>
						<section id="sb-status" class="box-wrap">
							<h2 class="title">{{ __('Status') }}<small class="required">(*)</small></h2>
							<div class="form-group">
								<select name="status" class="form-control select2" required>
									<option value="" disabled selected>Chọn trạng thái</option>
									{!! display_status_option() !!}
								</select>
							</div>
						</section>
					</div>
				</div>			
			</form>
		</div>
	</div>
	@include('backend.media.library')
	<script type="text/javascript">
		ckeditor("editor");
	</script>
@endsection