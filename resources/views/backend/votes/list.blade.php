@extends('backend.layout.index')
@section('title','Phiếu')
@section('content')
	<div id="writers" class="page productCats-page product-page">
		<div class="head container">
			<h1 class="title">{{ _('Phiếu') }}</h1>
			<a href="{{ route('createVoteAdmin') }}" class="btn btn-add">{{ _('Thêm mới') }}</a>
		</div>	
		<div class="main container">
			<form action="{{ route('votesAdmin') }}" method="GET" class="dev-form activity-s-form" data-delete="{{ route('deleteAllVoteAdmin') }}">
				{{ csrf_field() }}
				<div id="tb-result" class="table-responsive">
					@include('backend.votes.table')
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
