@extends('backend.layout.index')
@section('title','Sửa thành viên')
@section('content')
@php
	$type_author = getTypeAuthor();
@endphp
	<div id="edit-user" class="page route container">
		<div class="head">
			<a href="{{ route('users') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ _('Tất cả') }}</a>
			<h1 class="title">{{ $user->name }}</h1>	
		</div>	
		<form id="{{ $user->id }}" action="{{ route('updateUser',['id'=>$user->id]) }}" method="post" name="addUser" class="dev-form edit-post user-form" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="row">
				<div class="col-md-9 content clearfix">
					<div class="form-group" id="frm-name">
						<label for="name">{{ _('Họ tên') }}<small>(*)</small></label>
						<input type="text" name="name" class="form-control" value="{{ $user->name }}"/>
					</div>
					<div class="form-group" id="frm-phone">
						<label for="phone">{{ _('Số điện thoại') }}</label>
						<input type="text" name="phone" class="form-control" value="{{ $user->phone }}"/>
					</div>
					<div class="form-group" id="frm-email">
						<label for="email">{{ _('Email') }}<small>(*)</small></label>
						<input type="email" name="email" class="form-control" value="{{ $user->email }}"readonly/>
					</div>
					<div id="roles-sex" class="row">
						<div class="col-md-6">
							<div class="form-group custom-controls-stacked d-block my-3" id="frm-sex">
								<label for="sex" class="lb-sex">{{ _('Giới tính') }}</label>
								<div class="radio radio-success radio-inline">
									<input name="sex" type="radio" id="sex-nam" class="custom-control-input" value="Nam" @if($user->sex == 'Nam') {{ "checked" }} @endif>
									<label for="sex-nam">{{ _('Nam') }}</label>
								</div>
								<div class="radio radio-success radio-inline">
									<input name="sex" type="radio" id="sex-nu" class="custom-control-input" value="Nữ" @if($user->sex == 'Nữ') {{ "checked" }} @endif>
									<label for="sex-nu">{{ _('Nữ') }}</label>
								</div>
							</div>
						</div>
					</div>	
					<div class="checkbox checkbox-success check-password">
						<input id="change-password" type="checkbox" name="changePassword">
						<label for="change-password">{{ _('Thay đổi mật khẩu') }}</label>
					</div>
					<div class="change-password">
						<div class="form-group" id="password">
							<label for="password">{{ _('Mật khẩu') }}<small>(*)</small></label>
							<input type="password" name="password" class="form-control" value="" disabled placeholder="***" />
						</div>			
						<div class="form-group" id="confirmPassword">
							<label for="confirmPassword">{{ _('Xác nhận mật khẩu') }}<small>(*)</small></label>
							<input type="password" name="confirmPassword" class="form-control" value="" disabled placeholder="***" />
						</div>
					</div>
					@can('shows.read')
						@php 
						$userMeta = getUserMeta($user->id , 'bankinfo'); 
						@endphp
						@if($userMeta)
							@php 
								$bank = json_decode($userMeta->value);
							@endphp
							<div id="frm-bank">
								<div class="form-group">
									<label for="bankinfo">{{ _('Thông tin tài khoản ngân hàng') }}<small>(*)</small></label>
								</div>
								<div class="form-group">
									<input type="text" name="Username" class="form-control" value="{{ $bank->name ? $bank->name : '' }}" placeholder="Tên tài khoản" />
								</div>
								<div class="form-group">
									<input type="text" name="Numberphone" class="form-control" value="{{ $bank->numberPhone ? $bank->numberPhone : ''}}" placeholder="Số TK hoặc số điện thoại" />
								</div>
								<div class="form-group">
									<input type="text" name="Namebank" class="form-control" value="{{ $bank->nameBank ? $bank->nameBank : '' }}" placeholder="Tên ngân hàng" />
								</div>
							</div>
						@else
							<div id="frm-bank">
								<div class="form-group">
									<label for="bankinfo">{{ _('Thông tin tài khoản ngân hàng') }}<small>(*)</small></label>
								</div>
								<div class="form-group">
									<input type="text" name="Username" class="form-control" value="" placeholder="Tên tài khoản" />
								</div>
								<div class="form-group">
									<input type="text" name="Numberphone" class="form-control" value="" placeholder="Số TK hoặc số điện thoại" />
								</div>
								<div class="form-group">
									<input type="text" name="Namebank" class="form-control" value="" placeholder="Tên ngân hàng" />
								</div>
							</div>	
						@endif
					@endcan			
				</div>
				<div class="col-md-3 sidebar clearfix">
					<section id="sb-image" class="box-wrap">
						<h2 class="title">{{ _('Avatar') }}</h2>
						<div id="frm-image" class="desc img-upload">
							<div class="image">
								<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
								{!! image($user->image,220,142,$user->name) !!}
								<input type="hidden" name="image" class="thumb-media" value="{{ $user->image }}" />
							</div>
						</div>
					</section>
				</div>
			</div>		
			<div class="group-action">
				<a href="{{ route('deleteAdmin',['id'=>$user->id]) }}" class="btn btn-delete">{{ _('Delete') }}</a>
				<button type="submit" name="submit" class="btn">{{ _('Cập nhật') }}</button>
				<a href="{{ route('users') }}" class="btn btn-cancel">{{ _('Huỷ') }}</a>
			</div>
		</form>
	</div>
	@include('backend.media.library')
	@if(session('success'))
		<script type="text/javascript">
			$(document ).ready(function(){
				new PNotify({
					title: 'Thành công',
					text: 'Update user success.',
					type: 'success',
					hide: true,
					delay: 2000,
				});
			})
		</script>
	@endif
	@if(count($errors)>0)
		<div class="alert alert-danger"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
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
	<script type="text/javascript">
		$(document).ready(function(){
			//change password
			$(".check-password input").change(function(){
				if($(this).is(':checked')){
					$(".change-password input").prop('disabled', false);
					$(this).val("on");
				}else{
					$(".change-password input").prop('disabled', true);
					$(this).val("");
				}
				$(".change-password").slideToggle(100);
			});
			//validate form
			$("#edit-user .dev-form").on('click', '.group-action button',function(){
				var name = $(".dev-form #frm-name input").val();
				var sex = $(".dev-form #frm-sex input:checked").val();
				var errors = new Array();
				var error_count = 0;
				if(name == "") errors.push('Vui lòng nhận họ tên!');
				if(sex == undefined) errors.push('Vui lòng chọn giới tính!');
				var i;
				var html = "<ul>";
				for(i = 0; i < errors.length; i++){
					if(errors[i] != ""){
						html +='<li>'+errors[i]+'</li>';
						error_count += 1;
					}
				}
				html += "</ul>";
				if(error_count>0){
					new PNotify({
						title: 'Lỗi dữ liệu ('+error_count+')',
						text: html,
						hide: true,
						delay: 6000,
					});
				}else{
					$('#overlay').show();
					$('.loading').show();
					return true;
				}
				return false;
			});
			$("#edit-user .btn-delete").click(function(){
				var href = $(this).attr("href");
				(new PNotify({
					title: 'Xoá',
					text: 'Bạn muốn xoá thành viên này?',
					icon: 'glyphicon glyphicon-question-sign',
					type: 'error',
					hide: false,
					confirm: {
						confirm: true
					},
					buttons: {
						closer: false,
						sticker: false
					},
					history: {
						history: false
					}
				})).get().on('pnotify.confirm', function() {
					window.location.href = href;
				});
				return false;
			});
		});
	</script>
@endsection