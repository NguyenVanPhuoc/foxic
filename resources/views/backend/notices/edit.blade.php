
@extends('backend.layout.index')
@section('title','Sửa Thông Báo')
@section('content')
@php
	$types = selectUserToTheNotification();
@endphp
	<div id="edit-cat" class="container route">
		<div class="head">
			<a href="{{ route('noticesAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ __('Tất cả') }}</a>
			<h1 class="title">{{ __('Sửa Thông báo') }}</h1>
		</div>
		<div class="main">
			<form action="{{ route('updateNoticeAdmin', $notice->id) }}" class="dev-form activity-form" method="POST" role="form">
				{{ csrf_field() }}
				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<label for="title">{{ __('Tên thông báo') }}<small class="required">(*)</small></label>
							<input type="text" name="title" class="form-control" placeholder="Tên thông báo" required value="{{$notice->title}}">
						</div>
						<div class="form-group">
							<label>{{ __('Nội dung') }}</label>
							<span class="count-characters"></span>
							<textarea name="content" id="editor" class="form-control">{{$notice->content}}</textarea>
						</div>
						<div class="group-action">
							<button type="submit" name="submit" class="btn">{{ __('Lưu') }}</button>
							<a href="{{ route('noticesAdmin') }}" class="btn btn-cancel">{{ __('Huỷ') }}</a>
						</div>
					</div>
					<div class="col-md-3 sidebar">
						<section id="sb-image" class="box-wrap">
							<h3 class="title">Ảnh đại diện</h3>
							<div id="frm-image" class="form-group img-upload">
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!! image($notice->image,150,150,'$notice->title') !!}
									<input type="hidden" name="image" class="thumb-media" value="{{$notice->image}}">
								</div>
							</div>
						</section>
						<section id="sb-roles" class="box-wrap">
							<h2 class="title">{{ __('Chọn người nhận') }}<small class="required">(*)</small></h2>
							@if($roles)
                                <select multiple="multiple"  name="role[]" class="form-control select2" disabled>
		                            @foreach($roles as $role)
		                                <option value="{{ $role->id }}" {{ in_array($role->id,$notice->role) ? 'selected' : ''}}>{{ $role->name }}</option>
		                            @endforeach
		                        </select>
                            @endif
						</section>
						<section id="sb-types" class="box-wrap">
							<h2 class="title">{{ __('Chọn thành viên nhận thông báo') }}<small class="required">(*)</small></h2>
							@if($types)
                                <select name="role[]" class="form-control select2" disabled>
		                            @foreach($types as $key => $type)
		                                <option value="{{ $key }}" {{$key == $notice->type ? 'selected' : ''}}>{{ $type }}</option>
		                            @endforeach
		                        </select>
                            @endif
						</section>
					</div>
				</div>			
			</form>
		</div>
	</div>
	@include('backend.media.library')
	<script type="text/javascript">
		ckeditor("editor");
	</script>
@endsection