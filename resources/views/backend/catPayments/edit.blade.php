
@extends('backend.layout.index')
@section('title','Sửa thanh toán')
@section('content')
	<div id="edit-cate" class="container route">
		<div class="head">
			<a href="{{ route('catPaymentsAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ __('Tất cả') }}</a>
			<h1 class="title">{{ __('Sửa thanh toán') }}</h1>
		</div>
		<div class="main">
			<form action="{{ route('updateCatPaymentAdmin', $cate->id) }}" class="dev-form activity-form" method="POST" role="form">
				{{ csrf_field() }}
				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<label for="title">{{ __('Tên thanh toán') }}<small class="required">(*)</small></label>
							<input type="text" name="title" class="form-control" placeholder="Input title" value="{{ $cate->title }}">
						</div>
						<div class="form-group">
							<label class="metaValue">{{ __('Mô tả') }}</label>
							<span class="count-characters"></span>
							<textarea name="description" class="form-control" id="editor">{{ $cate->description }}</textarea>
						</div>
						<div class="group-action">
							<button type="submit" name="submit" class="btn">{{ __('Cập nhật') }}</button>
							<a href="{{ route('catPaymentsAdmin') }}" class="btn btn-cancel">{{ __('Huỷ') }}</a>
						</div>
					</div>
					<div class="col-md-3 sidebar">
						<section id="sb-image" class="box-wrap">
							<h3 class="title">Ảnh đại diện</h3>
							<div id="frm-image" class="form-group img-upload">
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!! image($cate->image,150,150,'Ảnh đại diện') !!}
								<input type="hidden" name="image" class="thumb-media" value="{{ $cate->image }}" />
								</div>
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