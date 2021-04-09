@extends('templates.auth')
@section('title','Login | Truyenfull')
@section('content')
	<div id="login-page" class="page">
		<div class="container">
			<div id="login-from" class="box">
				<h1 id="logo"><a href="{{ route('home') }}">{!! getLogo() !!}</a></h1>
				<div class="wrap">
					<form action="{{ route('postLogin') }}" method="post" name="login" role="form" class="login-form">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<div class="form-group" id="frm-email"><input type="email" placeholder="Your email" name="phone" class="txt"/></div>
						<div class="form-group" id="frm-pass"><input type="password" placeholder="Your password" name="password" class="txt"></div>
						<div class="form-group" id="frm-submit"><input type="submit" name="submit" value="Sign in" class="btn"></div>
					</form>
					{{-- <ul class="login-social">
						<li><a href="#" class="fbook"><i class="fab fa-facebook-f"></i>{{ _('Sign in to Facebook') }}</a></li>
						<li><a href="#" class="google"><i class="fab fa-google-plus-g"></i>{{ _('Sign in to Google+') }}</a></li>
					</ul> --}}
					<div class="bottom">
						<p class="question-txt">{{ _('Forgot your password?') }} <a href="{{ route('forgotPassword') }}">{{ _('Rehibilitate') }}</a></p>
						<p class="regis-txt">{{ _('Do not have an account?') }} <a href="{{ route('register') }}">{{ _('Register now') }}</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection