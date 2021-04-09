@extends('backend.layout.index')
@section('title','Truyện')
@section('content')
	<div id="comics" class="page">
		<div class="head ">
			<h1 class="title">{{ _('Truyện') }}</h1>
		</div>	
		<div class="main">
			<form action="{{ route('comicsAdmin') }}" method="GET" name="product_cat" class="dev-form activity-s-form" data-delete="{{ route('deleteAllComicAdmin') }}">
				<div class="search-filter">
					<div class="search-form">
						<div class="row">
							<div class="col-md-3 mar-bottom">
								<div class="s-cat">
									<select name="cat_id" class="select2 form-control">
										<option value="">{{ _('Danh mục') }}</option>
										@foreach($list_cat as $cat)
											<option value="{{ $cat->id }}">{{ $cat->title }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-2 mar-bottom">
								<div class="s-type">
									<select name="type_id" class="select2 form-control">
										<option value="">{{ _('Thể loại') }}</option>
										@foreach($list_type as $type)
											<option value="{{ $type->id }}">{{ $type->title }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-2 mar-bottom">
								<div class="s-writer">
									<select class="select2 form-control" name="writer_id">
										<option value="">{{ _('Tác giả') }}</option>
										@foreach($list_writer as $writer)
											<option value="{{ $writer->id }}">{{ $writer->title }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-2 mar-bottom">
								<div class="s-artist">
									<select class="select2 form-control" name="artist_id">
										<option value="">{{ _('Họa sĩ') }}</option>
										@foreach($list_artist as $artist)
											<option value="{{ $artist->id }}">{{ $artist->title }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-3 mar-bottom">
								<div class="s-key">
									<input type="text" name="s" class="form-control s-key" placeholder="Nhập từ khoá..." value="">
								</div>
							</div>
						</div>
						<button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>
					</div>
				</div>
				<div id="tb-result" class="table-responsive">
					@include('backend.comics.table')
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
