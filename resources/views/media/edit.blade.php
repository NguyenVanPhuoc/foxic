@extends('templates.master')
@section('title','Sửa file')
@section('content')
	<div id="edit-media" class="page profile media">
		<div class="container">
			<div class="pro-wrap">	
				<div id="pro-main" class="row">
					<div id="sidebar" class="sb-left col-md-3">@include('sidebars.member')</div>
					<div id="main" class="col-md-9">
						@include('members.profile_header')
						<form action="{{ route('updateMediaProfile',['id'=>$media->id]) }}" class="frm-menu dev-form" method="POST" name="editmedia" role="form">	
							{{ csrf_field() }}
							<div class="main-wrap">
								<div id="frm-title" class="form-group">
									<label for="urlImg">Tên file</label>
									<input type="text" name="title" class="form-control" placeholder="Nhập tên file" class="frm-input" value="{{ $media->title }}">
								</div>
								<div id="frm-url" class="form-group">
									<label for="urlImg">URL</label>
									<input type="text" name="urlImg" class="form-control" class="frm-input" value="<?php echo url('/public/uploads').'/'.$media->image_path;?>" readonly>
								</div>
								<div id="ct-image" class="unbox-wrap">
									<h3 class="ct-title">Ảnh đại diện</h3>
									<div id="frm-image" class="desc">
										<div class="image">
											{!! imageAuto($media->id,$media->title) !!}
										</div>
									</div>
								</div>
							</div>
							<div class="group-action clearfix">
								<a href="{{ route('deleteMediaProfile',['slug'=>$media->id]) }}" class="btn btn-delete btn-cs">Xóa</a>
								<button type="submit" name="submit" class="btn btn-cs">Lưu</button>
								<a href="{{ route('mediaProfile') }}" class="btn btn-cancel">Hủy</a>
							</div>
						</form>
					</div>
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