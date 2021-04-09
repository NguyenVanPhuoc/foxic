@extends('backend.layout.index')
@section('title','Thêm Yêu Cầu')
@section('content')
@php
	$status = getStatusWithdrawals();
@endphp
	<div id="create-cat" class="container route">
		<div class="head">
			<a href="{{ route('withdrawalsAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ __('Tất cả') }}</a>
			<h1 class="title">{{ __('Thêm Yêu Cầu') }}</h1>
		</div>
		<div class="main">
			<form action="{{ route('storeWithdrawalAdmin') }}" class="dev-form activity-form" method="POST" role="form">
				{{ csrf_field() }}
				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<label for="title">{{ __('Tài khoản yêu cầu rút') }}<small class="required">(*)</small></label>
							<input type="text" name="title" class="form-control" placeholder="Tài khoản yêu cầu rút" required>
						</div>
						<div class="form-group">
							<label for="point">{{ __('Số point yêu cầu rút') }}<small class="required">(*)</small></label>
							<input type="text" name="point" class="form-control" placeholder="Số point yêu cầu rút > 50" required>
						</div>
						{{-- <div class="form-group">
							<label>{{ __('Nội dung') }}</label>
							<span class="count-characters"></span>
							<textarea name="content" id="editor" class="form-control"></textarea>
						</div> --}}
						<div id="frm-bank">
							<div class="form-group">
								<label for="bankinfo">{{ _('Thông tin tài khoản ngân hàng') }}<small>(*)</small></label>
							</div>
							<div class="form-group">
								<input type="text" name="Username" class="form-control" value="" placeholder="Tên tài khoản" />
							</div>
							<div class="form-group">
								<input type="text" name="Numberphone" class="form-control" value="" placeholder="Số TK hoặc số điện thoại" />
							</div>
							<div class="form-group">
								<input type="text" name="Namebank" class="form-control" value="" placeholder="Tên ngân hàng" />
							</div>
						</div>
						<div class="group-action">
							<button type="submit" name="submit" class="btn">{{ __('Lưu') }}</button>
							<a href="{{ route('noticesAdmin') }}" class="btn btn-cancel">{{ __('Huỷ') }}</a>
						</div>
					</div>
					<div class="col-md-3 sidebar">
						@can('shows.status')
						<section id="sb-image" class="box-wrap">
							<h3 class="title">Ảnh xác nhận</h3>
							<div id="frm-image" class="form-group img-upload">
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!! image('',150,150,'Ảnh xác nhận') !!}
									<input type="hidden" name="image" class="thumb-media" value="">
								</div>
							</div>
						</section>
						<section id="sb-status" class="box-wrap">
							<h2 class="title">{{ __('Status') }}<small class="required">(*)</small></h2>
							<div class="form-group">
								<select name="status" class="form-control select2" required>
									<option value="" disabled selected>Chọn trạng thái</option>
									@foreach($status as $key => $item)
										<option value="{{$key}}">{{ $item }}</option>
									@endforeach
								</select>
							</div>
						</section>
						@endcan
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