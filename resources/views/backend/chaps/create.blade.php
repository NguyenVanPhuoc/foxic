@section('js')
	<script src="{{ asset('public/admin/js/comic.js') }}" type="text/javascript"></script> 
@endsection
@extends('backend.layout.index')
@section('title','Thêm chương')
@section('content')
	<div id="create-comic" class="container catProduct-page product-page route">
		<div class="head">
			<a href="{{ route('chapsAdmin',['comic_id'=>$comic->id,'book_id'=>$book->id]) }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ _('Tất cả chương của') }} {{ $book->title }}</a>
			<h1 class="title">{{ _('Thêm chương của') }} {{ $book->title }}</h1>
		</div>
		<div class="main">
			<form action="{{ route('storeChapAdmin',['comic_id'=>$comic->id,'book_id'=>$book->id]) }}" class="dev-form activity-form" method="POST" role="form">
				{{ csrf_field() }}
				<div class="row">
					<div id="frm-chap" class="form-group col-md-6">
						<label for="chap">{{ _('Chương') }}<small class="required">(*)</small></label>
						<input type="text" name="chap" class="form-control" placeholder="Nhập chương">
					</div>
					<div id="frm-short_chap" class="form-group col-md-6">
						<label for="short_chap">{{ _('Chương rút gọn') }}<small class="required">(*)</small></label>
						<input type="text" name="short_chap" class="form-control" placeholder="Nhập chương rút gọn">
					</div>
				</div>
				<div id="frm-tilte" class="form-group">
					<label for="title">{{ _('Tên chương') }}</label>
					<input type="text" name="title" class="form-control" placeholder="Nhập tên chương">
				</div>
				<div id="frm-content_chap" class="form-group">
					<label for="content_chap">{{ _('Nội dung chương') }}<small class="required">(*)</small></label>
					<textarea name="content" id="content_chap" class="form-control"></textarea>
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
				<div id="frm-rental" class="form-group">
					<label for="metakey">{{ _('Nhập số phiếu thuê') }}</label>
					<input name="rental" placeholder="Nhập số phiếu thuê" class="form-control"></input>
				</div>
				<div id="frm-point" class="form-group">
					<label for="metakey">{{ _('Nhập số point mua') }}</label>
					<input name="point" placeholder="Nhập số point mua" class="form-control"></input>
				</div>
				<div class="group-action">
					<button type="submit" name="submit" class="btn">{{ _('Lưu') }}</button>
					<a href="{{ route('chapsAdmin',['comic_id'=>$comic->id,'book_id'=>$book->id]) }}" class="btn btn-cancel">{{ _('Huỷ') }}</a>
				</div>
			</form>
		</div>
	</div>
	@include('backend.media.library')
	<script type="text/javascript">
		ckeditor("content_chap");
	</script>
@endsection