@extends('templates.master')
@section('title','Thêm file')
@section('content')
	<div id="create-media" class="page profile media">
		<div class="container">
			<div id="pro-main" class="row">
				<div class="sidebar sb-left col-md-3">@include('sidebars.member')</div>
				<div class="main col-md-9">
					@include('members.profile_header')
					<div class="main-wrap">
						<ul class="pro-menu">
							<li class="edit"><a href="{{ route('mediaProfile') }}"><i class="fas fa-chevron-left"></i><span class="hidden-1024">{{ _('Tất cả') }}</span></a></li>
							<li><span>{{ _('Thêm mới') }}</span></li>
						</ul>
						<div id="dropzone">
							<form action="{{ route('storeMediaProfile') }}" class="dropzone dev-form" id="my-awesome-dropzone">
								{{ csrf_field() }}
							</form>
						</div>
					</div>
					<div class="group-action">
						<a href="{{ route('mediaProfile') }}" class="btn btn-cancel">{{ _('Hủy') }}</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<link href="{{ asset('public/css/dropzone.css') }}" rel="stylesheet">
	<script src="{{ asset('public/js/dropzone.js') }}" type="text/javascript"></script>
@endsection