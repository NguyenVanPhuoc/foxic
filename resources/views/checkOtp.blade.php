@extends('templates.auth')
@section('title','Login | 5ship')
@section('content')

@php 
	if(session('notify')) :
		$notify = session('notify');
		$status = $notify['status'];
		$email = $notify['email'];
	else :
		$status = '';
		$email = '';
	endif;
@endphp

@if(($status=='true' && $email!='') || (session('error')))
	<div id="login-page" class="page">
		<div class="container">
			<div id="login-from" class="box">			
				<h1 id="logo"><a href="{{route('home')}}">{!! getLogo() !!}</a></h1>
				<div class="wrap">	
					<p class="well-txt">Bạn quên mật khẩu ?</p>						
					@if(session('error') != '')
						<div class="alert alert-danger">{{session('error')}}</div>
					@endif
					<form action="{{route('postCheckOtp')}}" method="post" name="login">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<input type="hidden" name="email" value="{{$email}}">
						<input type="text" placeholder="Nhập mã xác thực" name="otp" class="txt" />
						<input type="submit" name="submit" value="Đồng ý" class="btn">
					</form>
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