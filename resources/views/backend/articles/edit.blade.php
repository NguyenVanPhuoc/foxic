@php
	$seo = get_seo($article->id, 'article');
	$meta_key = $meta_value = '';
	if($seo){
		$meta_key = $seo->key;
		$meta_value = $seo->value;
	}
@endphp
@extends('backend.layout.index')
@section('title','Sửa Bài viết')
@section('content')
	<div id="edit-cat" class="container route">
		<div class="head">
			<a href="{{ route('articlesAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ __('Tất cả') }}</a>
			<h1 class="title">{{ __('Sửa Bài viết') }}</h1>
		</div>
		<div class="main">
			<form action="{{ route('updateArticleAdmin', $article->id) }}" class="dev-form activity-form" method="POST" role="form">
				{{ csrf_field() }}
				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<label for="title">{{ __('Tên bài viết') }}<small class="required">(*)</small></label>
							<input type="text" name="title" class="form-control" placeholder="Tên bài viết" required value="{{$article->title}}">
						</div>
						<div class="form-group">
							<label>{{ __('Mô tả ngắn') }}</label>
							<span class="count-characters"></span>
							<textarea name="desc" class="form-control" >{{$article->desc}}</textarea>
						</div>
						<div class="form-group">
							<label>{{ __('Nội dung') }}</label>
							<span class="count-characters"></span>
							<textarea name="content" id="editor" class="form-control">{{$article->content}}</textarea>
						</div>
						<div id="frm-metaKey" class="form-group">
							<label for="metakey">{{ __('Từ khoá (SEO)') }}</label>
							<input type="text" name="meta_key" class="form-control"  placeholder="Nhập từ khoá (SEO)" value="{{ $meta_key }}">
						</div>
						<div id="frm-metaValue" class="form-group">
							<label class="metaValue">{{ __('Mô tả meta (SEO) 150-160 ký tự') }}</label>
							<span class="count-characters"></span>
							<textarea name="meta_value" placeholder="Nhập mô tả meta (SEO) 150-160 ký tự" class="form-control">{{ $meta_value }}</textarea>
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
									{!! image($article->image,150,150,'$article->title') !!}
									<input type="hidden" name="image" class="thumb-media" value="{{$article->image}}">
								</div>
							</div>
						</section>
						<section id="sb-cate" class="box-wrap">
							<h2 class="title">{{ __('Danh mục') }}<small class="required">(*)</small></h2>
							<div class="form-group">
								<select name="cate_id[]" class="form-control select2 multiple" multiple required>
									{!! display_categoies_option($article->cate_id) !!}
								</select>
							</div>
						</section>
					
						<section id="sb-status" class="box-wrap">
							<h2 class="title">{{ __('Status') }}<small class="required {{ $article->status }}">(*)</small></h2>
							<div class="form-group">
								<select name="status" class="form-control select2" required>
									{!! display_status_option($article->status) !!}
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