@extends('backend.layout.index')
@section('title','Danh mục')
@section('content')
	@php
		$keyword = (isset($_GET["s"])) ? $_GET["s"] : '';
	@endphp
	<div id="cat-comics" class="page">
		<div class="head container">
			<h1 class="title">Thanh toán</h1>
		</div>	
		<div class="main">
			<a href="{{ route('createCatPaymentAdmin') }}" class="btn btn-primary">Thêm mới</a>
			<div class="row search-filter">
				<div class="col-md-6 search-form pull-right">
					<form name="s" action="#" method="GET">
						<div class="s-key">
							<input type="text" name="s" class="form-control s-key" placeholder="Nhập từ khoá..." value="{{ $keyword }}">
						</div>
						<button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>
					</form>
				</div>
			</div>
			<form action="#" method="POST" class="dev-form" data-delete="{{ route('deleteAllCatPaymentAdmin') }}">
				{{ csrf_field() }}
				<div id="tb-result">
					@include('backend.catPayments.table')				
				</div>
			</form>
		</div>
	</div>
	@if(session('success'))
		<script type="text/javascript">
			$(function(){
				new PNotify({
					title: 'Thành công',
					text: '{{ session('success') }}',
					type: 'success',
					hide: true,
					delay: 2000,
				});
			})
		</script>
	@endif
@endsection
