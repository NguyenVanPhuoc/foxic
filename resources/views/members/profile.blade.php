@extends('templates.master')
@section('title','Tài khoản')
@section('content')
<div id="profile" class="page profile">
	<div class="container">
		<div class="pro-wrap">
			<div id="pro-main" class="row">
				<div id="sidebar" class="sb-left col-md-3">@include('sidebars.member')</div>
				<div id="main" class="col-md-9">
					@include('members.profile_header')
				</div>
			</div>
		</div>
	</div>
	@include('media.library')
</div>	
@endsection