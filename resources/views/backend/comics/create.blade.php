@extends('backend.layout.index')
@section('title','Thêm truyện')
@section('content')
@php
	$AuStatus = authorStatusComic();
@endphp
	<div id="create-comic" class="container catProduct-page product-page route">
		<div class="head">
			<a href="{{ route('comicsAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ _('Tất cả') }}</a>
			<h1 class="title">{{ _('Thêm truyện') }}</h1>
		</div>
		<div class="main">
			<form action="{{ route('storeComicAdmin') }}" class="dev-form activity-form" method="POST" role="form">
				{{ csrf_field() }}
				<div class="row">
					<div class="col-md-9 content">
						<div id="frm-title" class="form-group">
							<label for="title">{{ _('Tên truyện') }}<small class="required">(*)</small></label>
							<input type="text" name="title" class="form-control" placeholder="Nhập tên truyện">
						</div>
						{{-- <div id="frm-title_original" class="form-group">
							<label for="title_original">{{ _('Tên gốc') }}</label>
							<input type="text" name="title_original" class="form-control" placeholder="Nhập tên gốc">
						</div> --}}
						<div class="form-group">
							<label class="metaValue">{{ _('Mô tả') }}</label>
							<textarea name="desc" id="desc" placeholder="Nhập mô tả" class="form-control"></textarea>
						</div>
						<div id="frm-source" class="form-group">
							<label for="source">{{ _('Nguồn') }}</label>
							<input type="text" name="source" class="form-control"  placeholder="Nhập nguồn truyện">
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>{{ _('Thể loại') }}</label>
									@if($list_type)
		                                <select multiple="multiple"  name="type[]" class="form-control select2">
				                            @foreach($list_type as $type)
				                                <option value="{{ $type->id }}">{{ $type->title }}</option>
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
				                                <option value="{{ $writer->id }}">{{ $writer->title }}</option>
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
				                                <option value="{{ $artist->id }}">{{ $artist->title }}</option>
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
									<input name="mature" type="radio" id="yes" class="custom-control-input" value="1">
									<label for="yes">{{ _('Có') }}</label>
								</div>
								<div class="radio radio-success radio-inline">
									<input name="mature" type="radio" id="no" class="custom-control-input" value="0">
									<label for="no">{{ _('Không') }}</label>
								</div>
							</div>
						</div>
						<div id="frm-metaKey" class="form-group">
							<label for="metakey">{{ __('Từ khoá (SEO)') }}</label>
							<input type="text" name="meta_key" class="form-control"  placeholder="Nhập từ khoá (SEO)" value="">
						</div>
						<div id="frm-metaValue" class="form-group">
							<label class="metaValue">{{ __('Mô tả meta (SEO) 150-160 ký tự') }}</label>
							<span class="count-characters">( {{ __('0 ký tự') }})</span>
							<textarea name="meta_value" placeholder="Nhập mô tả meta (SEO) 150-160 characters" class="form-control"></textarea>
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
												<input value="{{ $item->id }}" type="checkbox" name="categories[]" id="cat-{{ $item->id }}">
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
									{!! image('',150,150,'Image') !!}
									<input type="hidden" name="image" class="thumb-media" value="">
								</div>
							</div>
						</section>
						<section id="sb-auStatus" class="box-wrap">
							<h2 class="title">{{ _('Tình trạng') }}</h2>
							<div id="frm-auStatus"  class="form-group">
								<select class="select2" name="au_status">
									<option value="">{{ __('Chọn tình trạng') }}</option>
									@foreach ($AuStatus as $item)
										<option value="{{ $item }}">{{ $item }}</option>
									@endforeach
								</select>
							</div>
						</section>
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
	<script type="text/javascript">
		ckeditor("desc");
	</script>
@endsection