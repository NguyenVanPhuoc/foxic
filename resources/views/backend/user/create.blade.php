@extends('backend.layout.index')
@section('title','Thêm thành viên')
@section('content')
@php
	$type_author = getTypeAuthor();
@endphp
	<div id="create-user" class="page route container">
		<div class="head">
			<a href="{{ route('users') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ _('Tất cả') }}</a>
			<h1 class="title">{{ _('Thêm thành viên') }}</h1>
		</div>	
		<form action="{{ route('storeAdmin') }}" method="post" name="addUser" class="dev-form edit-post user-form" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="row">
				<div class="col-md-9 content clearfix">
					<div class="form-group" id="frm-name">
						<label for="name">{{ _('Họ tên') }}<small>(*)</small></label>
						<input type="text" name="name" class="form-control" value="{{ old('name') }}"/>
					</div>
					<div class="form-group" id="frm-phone">
						<label for="phone">{{ _('Số điện thoại') }}</label>
						<input type="text" name="phone" class="form-control" value="{{ old('phone') }}"/>
					</div>
					<div class="form-group" id="frm-email">
						<label for="email">{{ _('Email') }}<small>(*)</small></label>
						<input type="email" name="email" class="form-control" value="{{ old('email') }}"/>
					</div>				
					<div class="form-group" id="frm-pass">
						<label for="password">{{ _('Mật khẩu') }}<small>(*)</small></label>
						<input type="password" name="password" class="form-control" placeholder="***" />
					</div>			
					<div class="form-group" id="frm-conPass">
						<label for="confirmPassword">{{ _('Xác nhận mật khẩu') }}<small>(*)</small></label>
						<input type="password" name="confirmPassword" class="form-control" placeholder="***" />
					</div>
					<div id="roles-sex" class="row">
						<div class="col-md-6">
							<div class="form-group custom-controls-stacked d-block my-3" id="frm-sex">
								<label for="sex" class="lb-sex">{{ _('Giới tính') }}</label>
								<div class="radio radio-success radio-inline">
									<input name="sex" type="radio" id="sex-nam" class="custom-control-input" value="Nam">
									<label for="sex-nam">{{ _('Nam') }}</label>
								</div>
								<div class="radio radio-success radio-inline">
									<input name="sex" type="radio" id="sex-nu" class="custom-control-input" value="Nữ">
									<label for="sex-nu">{{ _('Nữ') }}</label>
								</div>
							</div>
						</div>
						@if(isset($roles))
							<div class="col-md-6" id="frm-roles">
								<label for="role">{{ _('Phân quyền') }}<small>(*)</small></label>
								<select name="role"><option value="">--Chọn--</option>
									@foreach($roles as $role)
										<option value="{{$role->name}}">{{$role->name}}</option>
									@endforeach
								</select>
							</div>
						@endif
					</div>
					
				</div>
				<div class="col-md-3 sidebar clearfix">
					<section id="sb-image" class="box-wrap">
						<h2 class="title">{{ _('Ảnh đại diện') }}</h2>
						<div id="frm-image" class="desc img-upload">
							<div class="image">
								<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
								{!! image('',150,150,'Ảnh đại diện') !!}
								<input type="hidden" name="image" class="thumb-media" value="">
							</div>
						</div>
					</section>
					<section id="sb-levels" class="box-wrap">
						<h2 class="title">{{ _('Cấp độ') }}</h2>
						<div id="frm-levels" class="desc img-upload">
							<select name="levels" class="levels select2">
								<option value="">{{ __('Chọn cấp độ') }}</option>
								@foreach($levels as $item)
									<option value="{{ $item->id }}">{{$item->title}}</option>
								@endforeach
							</select>
						</div>
					</section>
					<section id="frm-type" class="box-wrap">
						<label for="type_author">{{ _('Loại tác giả') }}</label>
						<select name="type_author"><option value="">--Chọn--</option>
							@foreach($type_author as $key => $type)
								<option value="{{$key}}">{{$type}}</option>
							@endforeach
						</select>
					</section>
				</div>
			</div>		
			<div class="group-action">
				<button type="submit" name="submit" class="btn">{{ _('Lưu') }}</button>
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
					text: '{{ session("success") }}',
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
			$("#roles-sex select").change(function(){
				var role = $(this).val();
				if(role=="member"){
					var html = '<div class="form-group" id="frm-amount">';
						html += '<label for="amount">Số điểm</label>';
						html += '<input type="amount" name="amount" class="form-control" value="0">';
						html +='</div>';
					$("#roles-sex").after(html);
				}else{
					$("#frm-amount").remove();
				}
			})
			//validate form
			$("#create-user .dev-form").on('click', '.group-action button',function(){
				var name = $(".dev-form #frm-name input").val();
				var phone = $(".dev-form #frm-phone input").val();
				var email = $(".dev-form #frm-email input").val();
				var pass = $(".dev-form #frm-pass input").val();
				var conPass = $(".dev-form #frm-conPass input").val();
				var sex = $(".dev-form #frm-sex input:checked").val();
				var role = $(".dev-form #frm-roles select").val();
				var errors = new Array();
				var error_count = 0;
				if(name == "") errors.push('Vui lòng nhập họ tên');
				if(email == "" || validateEmail(email)==false) errors.push('Email không đúng định dạng!');
				if(pass == "") errors.push('Vui lòng nhập mật khẩu!');
				if(conPass != pass) errors.push('Mật khẩu đã nhập không đúng!');
				if(sex == undefined) errors.push('Vui lòng chọn giới tính!');
				if(role == "") errors.push('Vui lòng chọn phân quyền!');
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
		});
	</script>
@endsection