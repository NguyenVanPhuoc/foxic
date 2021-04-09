@extends('backend.layout.index')
@section('title','Quyển của ' . $comic->title)
@section('content')
	@php $keyword = (isset($_GET["s"])) ? $_GET["s"] : ''; @endphp
	<div id="comics" class="page container">
		<div class="head ">
			<a href="{{ route('comicsAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> Tất cả</a>
			<h1 class="title">{{ _('Quyển của') }} {{ $comic->title }}</h1>
			<a href="{{ route('createBookAdmin', $comic->id) }}" class="btn">{{ _('Thêm quyển') }}</a>
		</div>	
		<div class="main">
			<form action="#" method="POST" name="product_cat" class="dev-form">
				{{ csrf_field() }}
				<div id="list-result" class="table-responsive">
					@include('backend.books.table')
				</div>
			</form>
		</div>
	</div>
	

	@if(session('success'))
		<script type="text/javascript">
			$(function(){
				new PNotify({
					title: 'Successfully',
					text: '{{ session('success') }}',
					type: 'success',
					hide: true,
					delay: 2000,
				});
			})
		</script>
	@endif
@endsection
