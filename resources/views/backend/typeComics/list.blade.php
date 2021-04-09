@extends('backend.layout.index')
@section('title','Thể loại truyện')
@section('content')
	@php $keyword = (isset($_GET["s"])) ? $_GET["s"] : ''; @endphp
	<div id="type-comics" class="page">
		<div class="head container">
			<h1 class="title">{{ _('Thể loại truyện') }}</h1>
			<a href="{{ route('createTypeComicAdmin') }}" class="btn btn-add">{{ _('Thêm mới') }}</a>
		</div>	
		<div class="main container">
			<form action="#" method="POST" name="product_cat" class="dev-form" data-delete="{{ route('deleteAllCatComicAdmin') }}">
				{{ csrf_field() }}
				<div id="list-result">
					@if($list_type)
						<section class="box-wrap">
							<h2 class="title">{{ _('Thể loại truyện') }}</h2>
							<ul class="sortable list-item" data-action="{{ route('positionTypeComicAdmin') }}">
								@foreach($list_type as $key => $item) 
									<li class="ui-state-default" data-value="{{ $item->id }}" data-position="{{ $key+1 }}">
										{{ $item->showTitle() }}
										<p class="gr-right">
											<a href="{{ route('editTypeComicAdmin', $item->id) }}">{{ _('Sửa') }}</a>
											<a href="{{ route('deleteTypeComicAdmin', $item->id) }}" class="btn-delete">{{ _('Xoá') }}</a>
										</p>
									</li>
								@endforeach
							</ul>
						</section>
					@endif
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
