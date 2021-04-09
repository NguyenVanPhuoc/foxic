@extends('templates.auth')
@section('title','Đăng ký')
@section('content')
<div id="regsiter-page" class="login-regsiter">
    <div class="container">
        <div class="wrapper-login text-center">
          <img class="img-login" src="{{ asset('public/images/LOGO.png') }}" alt="logo...">
          <section>
            <header>
                <h2 class="title-form font-bold">{{ _('Đăng ký') }}</h2>
                <p class="desc-form">{{ _('Bạn có một tài khoản? ') }}<a href="{{ route('storeLoginCustomer') }}" class="btn-reg">{{ _("Đăng nhập!") }}</a></p>
            </header>
            @include('notices.index')
            <form class="register-frm cs-form" action="{{ route('postRegisterCustomer') }}" method="POST" data-toggle="validator" role="form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="text" name="username" id="username-reg" class="form-control" placeholder="Username">
                </div>
                <div class="form-group">
                    <input type="text" name="email" id="email-reg" class="form-control" placeholder="Your Email">
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password-reg" class="form-control" placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="password" name="confirmPassword" id="confirmPassword-reg" class="form-control" placeholder="Re-Password">
                </div>  
                <div class="form-group" id="frm-role">
                    <div class="radio radio-success radio-inline">
                        <input name="role" type="radio" class="custom-control-input" value="5">
                        <label for="role">{{ _('Thành viên') }}</label>
                    </div>
                    <div class="radio radio-success radio-inline">
                        <input name="role" type="radio" class="custom-control-input" value="2">
                        <label for="role">{{ _('Tác giả') }}</label>
                    </div>
                </div>      
                <div class="form-group">
                    <button type="submit" class="btn btn-login font-bold">{{ _('Đăng ký') }}</button>
                </div>
            </form>
          </section>
        </div>
    </div>
</div>
@endsection