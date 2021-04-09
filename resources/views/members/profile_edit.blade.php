@extends('templates.master')
@section('title','Tài khoản')
@section('content')
	<div id="edit-profile" class="page profile">
		<div class="container">
			<div id="pro-main" class="row">	
				<div id="sidebar" class="sb-left col-md-3">@include('sidebars.member')</div>
				<div id="main" class="col-md-9">
					@include('members.profile_header')
					<ul class="pro-menu">
						<li><span class="active">{{ _('Thông tin cá nhân') }}</span></li>
					</ul>
					<form action="{{ route('updateProfile') }}" method="post" name="editProfile" class="dev-form">
						{{ csrf_field() }}
						<div class="main-wrap">
							<div id="frm-email" class="form-group">
								<label for="email">{{ _('Email') }}</label>
								<input type="text" name="email" id="email" class="form-control" value="{{ $user->email }}"/ disabled>
							</div>
							<div id="frm-name" class="form-group">
								<label for="name">{{ _('Họ & tên') }}<small class="required">*</small></label>
								<input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}"/>
							</div>
							<div id="frm-phone" class="form-group">
								<label for="phone">{{ _('Điện thoại') }}<small class="required">*</small></label>
								<input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone }}"/>
							</div>
							<div id="frm-birthday" class="form-group date">
								<label for="birthday">{{ _('Ngày sinh') }}<small class="required">*</small></label>
								<input type="text" name="birthday" id="birthday" class="form-control" value="@if($user->birthday != '') {{ customDateConvert($user->birthday) }} @endif">
							</div>
							<div id="frm-address" class="form-group">
								<label for="address">{{ _('Địa chỉ') }}<small class="required">*</small></label>
								<textarea name="address" id="address" class="form-control" rows="3">{{ $user->address }}</textarea>
							</div>
							<div id="frm-introduce" class="form-group">
								<label for="introduce">{{ _('Giới thiệu') }}</label>
								<textarea name="introduce" id="introduce" class="form-control" rows="3">{{ $user->introduce }}</textarea>
							</div>
							<div class="form-group custom-controls-stacked d-block my-3" id="sex">
								<label for="sex" class="lb-sex">{{ _('Giới tính') }}<small class="required">*</small></label>
								<div class="radio radio-success radio-inline">
									<input name="sex" type="radio" id="sex-nam" class="custom-control-input" value="Nam" @if($user->sex == 'Nam') {{ "checked" }} @endif>
									<label for="sex-nam">{{ _('Nam') }}</label>
								</div>
								<div class="radio radio-success radio-inline">
									<input name="sex" type="radio" id="sex-nu" class="custom-control-input" value="Nu" @if($user->sex == 'Nu') {{ "checked" }} @endif>
									<label for="sex-nu">{{ _('Nữ') }}</label>
								</div>
							</div>
						</div>
						<div class="group-action">
							<button type="submit" name="submit" class="btn btn-cs">{{ _('Cập nhật') }}</button>
							<a href="{{ route('profile') }}" class="btn btn-cancel">{{ _('Trở lại') }}</a>
						</div>	
					</form>
				</div>
			</div>
		</div>
		@include('media.library')
	</div>
	@if(session('success'))
		<script type="text/javascript">
			$(document ).ready(function(){
				new PNotify({
					title: 'Thành công',
					text: 'Cập nhật thành công.',
					type: 'success',
					hide: true,
					delay: 2000,
				});
			})
		</script>
	@endif
	@if(count($errors)>0)
		<div class="alert alert-danger"><ul>@foreach($errors->all() as $error)<li>{{$error}}</li>@endforeach</ul></div>
		<script type="text/javascript">
			$(document ).ready(function(){
				new PNotify({
					title: 'Lỗi',
					text: $('.alert-danger').html(),
					type: 'error',
					hide: true,
					delay: 2000,
				});
			})
		</script>
	@endif
@endsection