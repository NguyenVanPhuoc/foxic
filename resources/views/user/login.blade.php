@extends('templates.auth')
@section('title','Đăng nhập')
@section('content')
<div id="login-cus" class="login-regsiter">
	<div class="container">
		<div class="wrapper-login text-center" >
	      <img class="img-login" src="{{ asset('public/images/LOGO.png') }}" alt="logo...">
	      <section>
	        <header>
	           	<h2 class="title-form font-bold">{{ _('Đăng nhập') }}</h2>
	      		<p class="desc-form">{{ _('Bạn chưa có tài khoản? ') }}<a href="{{ route('storeRegisterCustomer') }}" class="btn-reg">{{ _("Đăng ký!") }}</a></p>
	        </header>
	        @include('notices.index')
	        @php
				if(session('message')!=null)
					echo session('message');
			@endphp
	        <form class="login-form cs-form" action="{{ route('postLoginCustomer') }}" method="POST" data-toggle="validator" role="form" enctype="multipart/form-data">
	        	{{ csrf_field() }}
	        	<input type="hidden" name="link" value="{{ isset($_GET['link']) ? $_GET['link'] : ''}}">
		        <div class="form-group">
		            <input type="text" name="username" id="username" class="form-control" placeholder="Email">
		        </div>
		        <div class="form-group">
		            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
		        </div>
		        <div class="form-group">
		            <button type="submit" class="btn btn-login font-bold">{{ _('Đăng nhập') }}</button>
		        </div>
	        </form>
	        <div class="network">
	          <a href="{{ route('login.social',['social'=>'facebook']) }}" class="btn-facebook"><img src="{{ asset('public/images/icons/facebook.png') }}" alt="login...">Đăng nhập với Facebook</a>
	          <a href="{{ route('login.social',['social'=>'google']) }}" class="btn-google"><img src="{{ asset('public/images/icons/google.png') }}" alt="login...">Đăng nhập với Google</a>
	          <div class="come-back">
	            <a href="{{ route('forgotPassword') }}" class="btn-back btn-back-page">Quên mật khẩu</a>
	            {{-- <a href="{{ route('password.email') }}" class="btn-back btn-back-page">Quên mật khẩu</a> --}}
	            <a href="{{ route('home') }}" class="btn-back btn-back-page">Quay lại</a>
	          </div>
	        </div>
	      </section>
	    </div>
	</div>
</div>
@endsection