@extends('templates.auth')
@section('title','Register | Toomics')
@section('content')
	<div id="login-page" class="page p-register">
		<div class="container">
			<div id="login-from" class="box">
				<h1 id="logo"><a href="{{ route('home') }}">{!! getLogo() !!}</a></h1>
				<div class="wrap wrap-reg">
					<p class="well-txt well-reg-txt">{{ _('Creating an account is easy!') }}</p>
					<div class="alert alert-danger print-error-msg" style="display:none">
					<ul></ul></div>
					<form action="{{ route('postRegister') }}" method="post" name="register" role="form" class="register-frm">
						{{ csrf_field() }}
						<div id="frm-name" class="form-group"><input type="text" placeholder="Fullname" name="name" class="txt"></div>
						<div id="frm-email" class="form-group"><input type="email" placeholder="Email" name="email" class="txt"></div>
						<div id="frm-pass" class="form-group"><input type="password" placeholder="Password" name="password" class="txt"></div>
						<div id="frm-passConfirm" class="form-group"><input type="password" placeholder="Confirm password" name="passConfirm" class="txt"></div>
						<div id="frm-captcha" class="form-group">
							<div class="input-group">
								<input type="text" name="captcha" class="form-control" placeholder="Please enter captcha">
								<div class="input-group-addon">{!! captcha_img() !!}<i class="fas fa-sync-alt"></i></div>
							</div>
						</div>
						<div id="frm-submit" class="form-group"><input type="submit" name="submit" value="Register" class="btn"></div>
					</form>
					<div class="bottom">
						<p class="login-txt">{{ _('Do you already have an account?') }} <a href="{{ route('login') }}">{{ _('Login now') }}</a></p>
						<p class="note">{{ _('Choose to register as you agree') }} <a href="#">{{ _('Our Terms & Services') }}</a>.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection