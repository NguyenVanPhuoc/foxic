@extends('templates.auth')
@section('title','Forgot password | Toomics')
@section('content')
	@php 
		if(session('notify')) :
			$notify = session('notify');
			$status = $notify['status'];
			$email = $notify['email'];
		elseif(session('error')) :
			$notify = session('error');
			$email = $notify['email'];
			$status = '';
		elseif(session('success')) :
			$notify = session('success');
			$email = $notify['email'];
			$status = '';
		else :
			$status = '';
			$email = '';
		endif;
	@endphp
	@if(($status=='true' && $email!='') || (session('error')) || (session('success')))
		<div id="login-page" class="page">
			<div class="container">
				<div id="login-from" class="box">
					<h1 id="logo"><a href="{{ route('home') }}">{!! getLogo() !!}</a></h1>
					<div class="wrap">
						<p class="well-txt">{{ _('Password retrieval') }}</p>
						@if(session('error') != '') <div class="alert alert-danger">{{ $notify['msg'] }}</div> @endif
						@if(session('success') != '') <div class="alert alert-success">{{ $notify['msg'] }}</div> @endif
						<form action="{{ route('postRetakePassword') }}" method="post" name="login">
							{{ csrf_field() }}
							<input type="hidden" name="email" value="{{ $email }}">
							<input type="password" placeholder="Enter your new password" name="password" class="txt">
							<input type="password" placeholder="Enter the password" name="re_password" class="txt">
							<input type="submit" name="submit" value="Submit" class="btn">
						</form>
						<div class="bottom">
							<p class="question-txt text-right"><a href="{{ route('login') }}">{{ _('Sign in') }}</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	@else
		<script type="text/javascript">
			$(function() {
				window.location.replace("{{route('login')}}");
			});
		</script>
		
	@endif
@endsection