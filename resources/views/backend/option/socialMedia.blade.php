@extends('backend.layout.index')
@section('title','Mạng xã hội')
@section('content')
	<div id="system" class="container page">
		<div class="head"><h1 class="title">{{ _('Mạng xã hội') }}</h1></div>
		@if(count($errors)>0)
		<div class="alert alert-danger">
			<ul>
				@foreach($errors->all() as $error)
				<li>{{ $error }}</li>	
				@endforeach
			</ul>
		</div>
		@endif
		@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
		<form id="{{ $option->id }}" action="{{ route('editSocial') }}" method="post" name="option" class="dev-form edit-post social-form" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{csrf_token()}}"/>
			<div id="facebook" class="form-group">
				<label for="name">{{ _('Facebook') }}</label>
				<input type="text" name="facebook" class="form-control" value="{{ $option->facebook }}">
			</div>	
			<div id="google" class="form-group">
				<label for="google">{{ _('Goole Plus') }}</label>
				<input type="text" name="google" class="form-control" value="{{ $option->google }}">
			</div>		
			<div id="youtube" class="form-group">
				<label for="youtube">{{ _('Youtube') }}</label>
				<input type="text" name="youtube" class="form-control" value="{{ $option->youtube }}">
			</div>		
			<div id="twitter" class="form-group">
				<label for="Twitter">{{ _('Twitter') }}</label>
				<input type="text" name="twitter" class="form-control" value="{{ $option->twitter }}">
			</div>		
			<div id="instagram" class="form-group">
				<label for="instagram">{{ _('Instagram') }}</label>
				<input type="text" name="instagram" class="form-control" value="{{ $option->instagram }}">
			</div>	
			<div class="group-action">
				<button type="submit" class="btn">{{ _('Cập nhật') }}</button>
			</div>
		</form>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".edit-post .btn-group .btn").click(function(){
				var _token = $(".edit-post input[name='_token']").val();
				var post_id = parseInt($(".edit-post").attr("id"));
				var link = $(".edit-post").attr("action");
				var facebook = $('#facebook input').val();
				var google = $('#google input').val();
				var youtube = $("#youtube input").val(); 
				var twitter = $("#twitter input").val(); 
				var instagram = $("#instagram input").val(); 
				$.ajax({
					type:'POST',
					url:link,
					cache: false,
					data:{
						'_token': _token,
						'id': post_id,
						'facebook': facebook,
						'google': google,
						'youtube': youtube,
						'twitter': twitter,
						'instagram': instagram
					},
					success:function(data){
						if(data!="error"){
							$(".notify").html('<div class="alert alert-success">Cập nhật thành công</div>');
						}
					}
				})
				return false;
			});
		});
	</script>
@endsection