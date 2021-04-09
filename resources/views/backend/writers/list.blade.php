@extends('backend.layout.index')
@section('title','Tác giả')
@section('content')
	<div id="writers" class="page productCats-page product-page">
		<div class="head container">
			<h1 class="title">{{ _('Tác giả') }}</h1>
			<a href="{{ route('createWriterAdmin') }}" class="btn btn-add">{{ _('Thêm mới') }}</a>
		</div>	
		<div class="main container">
			<form action="{{ route('writersAdmin') }}" method="GET" class="dev-form activity-s-form" data-delete="{{ route('deleteAllWriterAdmin') }}">
				{{ csrf_field() }}
				<div class="search-filter">
					<div class="row">
						<div class="col-md-6 col-md-offset-6">
							<div class="search-form">
								<div class="s-key">
									<input type="text" name="s" class="form-control s-key" placeholder="Nhập từ khoá..." value="">
								</div>
								<button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>
							</div>
						</div>
					</div>
				</div>
				<div id="tb-result">
					@include('backend.writers.table')
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
