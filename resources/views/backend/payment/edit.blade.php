@extends('backend.layout.index')
@section('title','Sửa')
@section('content')
@php
	$package = get_package();
@endphp
	<div id="edit-cat" class="container route">
		<div class="head">
			<a href="{{ route('paymentsAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ __('Tất cả') }}</a>
			<h1 class="title">{{ __('Sửa') }}</h1>
		</div>
		<div class="main">
			<form action="{{ route('updatePaymentAdmin', $payment->id) }}" class="dev-form activity-form" method="POST" role="form">
				{{ csrf_field() }}
				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<label for="title">{{ __('Tên bài viết') }}<small class="required">(*)</small></label>
							<input type="text" name="title" class="form-control" placeholder="Tên bài viết" required value="{{$payment->title}}">
						</div>
						<div id="frm-amount" class="form-group">
							<label for="amount">{{ __('Số tiền') }}</label>
							<input type="text" name="amount" class="form-control"  placeholder="Nhập số tiền" value="{{$payment->amount}}">
						</div>
						<div class="group-action">
							<button type="submit" name="submit" class="btn">{{ __('Lưu') }}</button>
							<a href="{{ route('paymentsAdmin') }}" class="btn btn-cancel">{{ __('Huỷ') }}</a>
						</div>
					</div>
					<div class="col-md-3 sidebar">
						<section id="sb-cate" class="box-wrap">
							<h2 class="title">{{ __('Loại thanh toán') }}<small class="required">(*)</small></h2>
							<div class="form-group">
								<select name="pay_id" class="form-control select2 " required>
									@foreach($cate as $item)
										<option value="{{$item->id}}" {{ $item->id == $payment->catPayment->id ? 'selected' : ''}} >{{$item->title}}</option>
									@endforeach
								</select>
							</div>
						</section>
						<section id="sb-package" class="box-wrap">
							<h2 class="title">{{ __('Chọn gói') }}<small class="required">(*)</small></h2>
							<div class="form-group">
								<select name="package" class="form-control select2 " required>
									@foreach($package as $key => $value)
										<option value="{{$key}}" {{ $key == $payment->package ? 'selected' : ''}}>{{$value}}</option>
									@endforeach
								</select>
							</div>
						</section>
					</div>
				</div>			
			</form>
		</div>
	</div>
@endsection