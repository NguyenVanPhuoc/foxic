@extends('backend.layout.index')
@section('title','Chương của ' . $book->title)
@section('content')
	@php $keyword = (isset($_GET["s"])) ? $_GET["s"] : ''; @endphp
	<div id="comics" class="page container">
		<div class="head ">
			<a href="{{ route('booksAdmin',['comic_id'=>$comic->id,'book_id'=>$book->id]) }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i>  Tất cả quyển của {{$book->title}}</a>
			<h1 class="title">{{ _('Chương của') }} {{ $book->title }}</h1>
			<a href="{{ route('createChapAdmin',['comic_id'=>$comic->id,'book_id'=>$book->id]) }}" class="btn">{{ _('Thêm chương') }}</a>
		</div>	
		<div class="main">
			<form action="#" method="POST" name="product_cat" class="dev-form">
				{{ csrf_field() }}
				<div id="list-result" class="table-responsive">
					@include('backend.chaps.table')
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
