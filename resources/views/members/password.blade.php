@extends('templates.master')
@section('title','Đổi mật khẩu')
@section('content')
	<div id="edit-password" class="page profile">
		<div class="container">	
			<div id="pro-main" class="row">
				<div id="sidebar" class="sb-left col-md-3">@include('sidebars.member')</div>
				<div id="main" class="main col-md-9">
					@include('members.profile_header')
					<ul class="pro-menu">
						<li><span class="active">{{ _('Thay đổi mật khẩu') }}</span></li>
					</ul>
					<form action="{{ route('updatePassword') }}" method="post" name="updatePassword" class="dev-form">
						{{ csrf_field() }}
						<div class="main-wrap">
							<div id="frm-oldPass" class="form-group">
								<label for="name">{{ _('Mật khẩu cũ') }}<small class="required">*</small></label>
								<input type="password" name="oldPass" placeholder="**********" class="form-control" value="{{ old('oldPass') }}">
							</div>
							<div id="frm-newPass" class="form-group">
								<label for="name">{{ _('Mật khẩu mới') }}<small class="required">*</small></label>
								<input type="password" name="newPass" placeholder="**********" class="form-control" value="{{ old('newPass') }}">
							</div><div id="frm-confirmPass" class="form-group">
								<label for="confirmPass">{{ _('Nhập lại mật khẩu') }}<small class="required">*</small></label>
								<input type="password" name="confirmPass" placeholder="**********" class="form-control" value="{{ old('confirmPass') }}">
							</div>
						</div>
						<div class="group-action">
							<button type="submit" name="submit" class="btn btn-cs">{{ _('Cập nhật') }}</button>
							<a href="{{ route('profile') }}" class="btn btn-cancel">{{ _('Huỷ') }}</a>
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
					text: '{{session("success")}}',
					type: 'success',
					hide: true,
					delay: 2000,
				});
			})
		</script>
	@endif
	@if(session('error'))
		<script type="text/javascript">
			$(document ).ready(function(){
				new PNotify({
					title: 'Lỗi',
					text: '{{session("success")}}',
					type: 'error',
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