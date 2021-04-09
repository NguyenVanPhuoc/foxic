@extends('backend.layout.index')
@section('title','Sửa truyện')
@section('content')
	@php
		$seo = get_seo($comic->id, 'comic');
		$meta_key = $meta_value = '';
		if($seo){
			$meta_key = $seo->key;
			$meta_value = $seo->value;
		}
		$status=get_statusComic();
		$AuStatus = authorStatusComic();
	@endphp
	<div id="edit-comic" class="container catProduct-page product-page route">
		<div class="head">
			<a href="{{ route('comicsAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ _('Tất cả') }}</a>
			<h1 class="title">Sửa {{ $comic->showTitle() }}</h1>
			<div class="group-cs">
				<a href="{{ route('createBookAdmin', $comic->id) }}" class="btn">{{ _('Thêm chương') }}</a>	
				<a href="{{ route('booksAdmin', $comic->id) }}" class="btn-cs" title="All chaps"><i class="fal fa-file-signature"></i></a>				
			</div>			
		</div>
		<div class="main">
			<form action="{{ route('editComicAdmin', $comic->id) }}" class="dev-form activity-form" method="POST" role="form">
				{{ csrf_field() }}
				<div class="row">
					<div class="col-md-9 content">
						<div class="form-group">
							<label for="title">{{ _('Tên truyện') }}<small class="required">(*)</small></label>
							<input type="text" name="title" class="form-control" placeholder="Nhậo tên truyện" value="{{ $comic->title }}">
						</div>
						{{-- <div id="frm-title_original" class="form-group">
							<label for="title_original">{{ _('Tên gốc') }}</label>
							<input type="text" name="title_original" class="form-control" placeholder="Nhập tên gốc" value="{{ $comic->title_original }}">
						</div> --}}
						<div class="form-group">
							<label>{{ _('Mô tả') }}</label>
							<textarea name="desc" placeholder="Nhập mô tả" class="form-control">{{ $comic->desc }}</textarea>
						</div>
						<div id="frm-source" class="form-group">
							<label for="source">{{ _('Nguồn') }}</label>
							<input type="text" name="source" class="form-control"  placeholder="Nhập nguồn truyện" value="{{ $comic->source }}">
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>{{ _('Thể loại') }}</label>
									@if($list_type)
		                                <select multiple="multiple"  name="type[]" class="form-control select2">
				                            @foreach($list_type as $type)
				                                <option value="{{ $type->id }}" @if(in_array($type->id, $array_typeID)) selected @endif >{{ $type->title }}</option>
				                            @endforeach
				                        </select>
		                            @endif
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>{{ _('Tác giả gốc') }}</label>
									@if($list_writer)
		                                <select multiple="multiple"  name="writer[]" class="form-control select2">
				                            @foreach($list_writer as $writer)
				                                <option value="{{ $writer->id }}" @if(in_array($writer->id, $array_writerID)) selected @endif>{{ $writer->show_name() }}</option>
				                            @endforeach
				                        </select>
		                            @endif
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>{{ _('Họa sĩ') }}</label>
									@if($list_artist)
		                                <select multiple="multiple"  name="artist[]" class="form-control select2">
				                            @foreach($list_artist as $artist)
				                                <option value="{{ $artist->id }}" {{ in_array($artist->id, $array_artistID) ? 'selected' : '' }}>{{ $artist->show_name() }}</option>
				                            @endforeach
				                        </select>
		                            @endif
								</div>
							</div>
						</div>
						<div id="mature">
							<div class="form-group custom-controls-stacked d-block my-3" id="frm-mature">
								<label for="mature" class="lb-mature">{{ _('Nội dung trưởng thành') }}</label>
								<div class="radio radio-success radio-inline">
									<input name="mature" type="radio" id="yes" class="custom-control-input" value="1" @if($comic->mature == '1') {{ "checked" }} @endif>
									<label for="yes">{{ _('Có') }}</label>
								</div>
								<div class="radio radio-success radio-inline">
									<input name="mature" type="radio" id="no" class="custom-control-input" value="0" @if($comic->mature == '0') {{ "checked" }} @endif>
									<label for="no">{{ _('Không') }}</label>
								</div>
							</div>
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
					</div>
					<div class="col-md-3 sidebar">
						<section id="sb-cate" class="box-wrap">
							<h2 class="title">{{ _('Danh mục') }}</h2>
							<div class="form-group">
								@if($list_cat)
	                                <ul class="list-unstyled list-item">
	                                    @foreach($list_cat as $item)
	                                    <li class="checkbox checkbox-success">
	                                    	<input value="{{ $item->id }}" type="checkbox" name="categories[]" id="cat-{{$item->id}}" @if(in_array($item->id, $array_catID)) checked @endif >
	                                    	<label for="cat-{{ $item->id }}">{{ $item->title }}</label>
	                                    </li>
	                                    @endforeach
	                                </ul>
	                            @endif
							</div>
						</section>
						<section id="sb-image" class="box-wrap">
							<h2 class="title">{{ _('Image') }}</h2>
							<div id="frm-image"  class="form-group img-upload">
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!! image($comic->image,150,150,'Image') !!}
									<input type="hidden" name="image" class="thumb-media" value="{{ $comic->image }}">
								</div>
							</div>
						</section>
						<section id="sb-auStatus" class="box-wrap">
							<h2 class="title">{{ _('Tình trạng') }}</h2>
							<div id="frm-auStatus"  class="form-group">
								<select class="select2" name="au_status">
									<option value="" disabled>{{ __('Chọn tình trạng') }}</option>
									@foreach ($AuStatus as $key => $item)
										<option value="{{ $key }}" {{ $comic->au_status == $key ? 'selected' : ''}}>{{ $item }}</option>
									@endforeach
								</select>
							</div>
						</section>
					@can('comics.publish')
						<section id="sb-status" class="box-wrap">
							<h2 class="title">{{ _('Status') }}</h2>
							<div id="frm-status"  class="form-group">
								<select class="select2" name="status">
									<option value="" disabled>{{ __('Chọn trạng thái') }}</option>
									@foreach ($status as $key => $item)
										<option value="{{ $key }}" {{ $comic->status == $key ? 'selected' : ''}}>{{ $item }}</option>
									@endforeach
								</select>
							</div>
						</section>
					@endcan
					</div>
				</div>
				<div class="group-action">
					<a href="{{ route('deleteComicAdmin', $comic->id) }}" class="btn btn-delete" title="delete">{{ _('Xoá') }}</a>
					<button type="submit" name="submit" class="btn">{{ _('Cập nhật') }}</button>
					<a href="{{ route('catComicsAdmin') }}" class="btn btn-cancel">{{ _('Huỷ') }}</a>				
				</div>
			</form>
		</div>
	</div>
	@include('backend.media.library')
	<script type="text/javascript">
		ckeditor("desc");
	</script>
@endsection