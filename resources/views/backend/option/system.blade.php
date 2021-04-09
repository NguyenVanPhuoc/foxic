@extends('backend.layout.index')
@section('title','Thông tin hệ thống')
@section('content')
	<div id="system" class="container page">
		<div class="head"><h1 class="title">{{ _('Thông tin hệ thống') }}</h1></div>
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
		<form action="{{ route('editSytem') }}" method="post" name="option" class="dev-form edit-post" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="row">
				<div class="col-md-3">
					<div id="frm-logo" class="form-group img-upload">
						<label for="logo">{{ _('Logo') }}</label>
						<div class="image">
							<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
							@if($option!=null && $option->logo!=null)
								{!! imageAuto($option->logo,'Logo') !!}
								<input type="hidden" name="logo" id="logo" class="thumb-media" value="{{ $option->logo }}">
							@else
								{!! image('',150,150,'Logo') !!}
								<input type="hidden" name="logo" id="logo" class="thumb-media" value="">
							@endif
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div id="logo-light" class="form-group img-upload">
						<label for="logo_light">Logo Footer</label>
						<div class="image">
							<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
							@if($option!=null && $option->logo_light!=null)
								{!! imageAuto($option->logo_light,'Logolight') !!}
								<input type="hidden" name="logo_light" class="thumb-media" value="{{ $option->logo_light }}">
							@else
								{!! image('',150,150,'Logolight') !!}
								<input type="hidden" name="logo_light" class="thumb-media" value="">
							@endif
						</div>
					</div>
				</div>
				{{-- <div class="col-md-3">
					<div id="logo-chap" class="form-group img-upload">
						<label for="logo_chap">Logo Chap</label>
						<div class="image">
							<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
							@if($option!=null && $option->logo_viewer_chap!=null)
								{!! imageAuto($option->logo_viewer_chap,'Logolight') !!}
								<input type="hidden" name="logo_chap" class="thumb-media" value="{{ $option->logo_viewer_chap }}">
							@else
								{!! image('',150,150,'Logolight') !!}
								<input type="hidden" name="logo_chap" class="thumb-media" value="">
							@endif
						</div>
					</div>
				</div> --}}
				<div class="col-md-3">
					<div id="frm-favicon" class="form-group img-upload">
						<label for="favicon">{{ _('Favicon') }}</label>
						<div class="image">
							<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
							@if($option!=null && $option->favicon)
								{!! imageAuto($option->favicon,'Favicon') !!}
								<input type="hidden" name="favicon" id="favicon" class="thumb-media" value="{{ $option->favicon }}">
							@else
								{!! image('',150,150,'Favicon') !!}
								<input type="hidden" name="favicon" id="favicon" class="thumb-media" value="">
							@endif
						</div>
					</div>
				</div>
			</div>
			<div id="frm-title" class="form-group">
				<label for="title">{{ _('Tên Website') }}</label>
				@if($option!=null)
					<input type="text" name="title" id="title" class="form-control" value="{{ $option->title }}">
				@else
					<input type="text" name="title" id="title" class="form-control">
				@endif
			</div>
			{{-- <div id="frm-slogan" class="form-group">
				<label for="title">{{ _('Slogan') }}</label>
				@if($option!=null)
					<input type="text" name="slogan" id="slogan" class="form-control" value="{{ $option->slogan }}">
				@else
					<input type="text" name="slogan" id="slogan" class="form-control">
				@endif
			</div> --}}
			{{-- <div id="phone" class="form-group">
				<label for="name">Phone</label>
				@if($option!=null)
					<input type="text" name="phone" class="form-control" value="{{ $option->phone }}">
				@else
					<input type="text" name="phone" class="form-control">
				@endif
			</div> --}}
			<div id="frm-email" class="form-group">
				<label for="name">{{ _('Email') }}</label>
				@if($option!=null)
					<input type="email" name="email" id="email" class="form-control" value="{{ $option->email }}">
				@else
					<input type="email" name="email" id="email" class="form-control">
				@endif
			</div>
			<div id="address" class="form-group">
				<label for="name">Address</label>
				@if($option!=null)
					<textarea name="address"  class="form-control">{{ $option->address }}</textarea>
				@else
					<textarea name="address"  class="form-control"></textarea>
				@endif
			</div>
			<div id="facebook" class="form-group">
				<label for="name">Facebook Link</label>
				@if($option!=null)
					<input type="text" name="facebook" class="form-control" value="{{ $option->facebook }}" placeholder="Link facebook"/>
				@else
					<input type="text" name="facebook" class="form-control" placeholder="Link facebook"/>
				@endif
			</div>
			<div id="frm-copyright" class="form-group">
				<label for="copyright">{{ _('Copyright') }}</label>
				@if($option!=null)
					<textarea type="text"  name="copyright" id="copyright" class="form-control">{{ $option->copyright }}</textarea>
				@else
					<textarea type="text" name="copyright" id="copyright" class="form-control"></textarea>
				@endif
			</div>
			{{--<div id="#frm-tag_list" class="form-group">
				<label for="tag_list">{{ _('Danh sách tag') }}</label>
				@if ($option!=null)
					<textarea type="text" name="tag_list" id="tag_list"  class="form-control">{{ $option->tag_list }}</textarea>
				@else
					<textarea type="text" name="tag_list" id="tag_list"  class="form-control"></textarea>
				@endif
			</div>
			 <div id="mobiAddress" class="form-group">
				<label for="name">Address (App)</label>
				@if($option!=null)
					<input name="mobiAddress"  class="form-control" value="{{ $option->mobiAddress }}" placeholder="Địa chỉ liên hệ trên App">
				@else
					<input name="mobiAddress"  class="form-control"  placeholder="Địa chỉ liên hệ trên App">
				@endif
			</div>
			<div id="map" class="form-group">
				<label for="name">Map</label>
				<div class="row">
					@if($option!=null)
						<div class="col-md-6 lag"><input type="text" name="lag" class="form-control" value="{{ $option->lag }}" placeholder="tọa độ lag"/></div>
						<div class="col-md-6 log"><input type="text" name="log" class="form-control" value="{{ $option->log }}" placeholder="tọa độ log"/></div>
					@else
						<div class="col-md-6 lag"><input type="text" name="lag" class="form-control" placeholder="tọa độ lag"></div>
						<div class="col-md-6 log"><input type="text" name="log" class="form-control" placeholder="tọa độ log"></div>
					@endif
				</div>
			</div>
			<div id="website" class="form-group">
				<label for="name">Website Link</label>
				@if($option!=null)
					<input type="text" name="website" class="form-control" value="{{ $option->website }}" placeholder="Link website"/>
				@else
					<input type="text" name="website" class="form-control" placeholder="Link website"/>
				@endif
			</div>
			<div id="token_api" class="form-group">
				<label for="name">Token API</label>
				@if($option!=null)
					<input type="text" name="token_api" class="form-control" value="{{ $option->token_api }}"/>
				@else
					<input type="text" name="token_api" class="form-control"/>
				@endif
			</div>
			<div id="frm-content-vip-package" class="form-group">
				<label for="content">{{ _("Content Vip Package") }}</label>
				<textarea name="content_vip_package" id="editor" class="form-control">{!! $option->content_vip_package !!}</textarea>
			</div>
			<div id="frm-desc-vip-package" class="form-group">
				<label for="content">{{ _("Description Vip Package") }}</label>
				<textarea name="desc_vip_package"  class="form-control">{!! $option->desc_vip_package !!}</textarea>
			</div> --}}
			<div class="group-action">
				<button type="submit" class="btn">{{ _('Cập nhật') }}</button>
			</div>
		</form>
	</div>
	@include('backend.media.library')
	<script type="text/javascript">
		ckeditor("copyright");
		ckeditor("tag_list");
	</script>
@endsection