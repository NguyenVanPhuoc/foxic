@extends('backend.layout.index')
@section('title','edit role')
@section('content')
	<div id="edit-role" class="container page ">
		@include('notices.index')
		<div class="head">
			<div class="nav">
				<a href="{{ route('rolesAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ _('Tất cả') }}</a>
			</div>
			<h1 class="title">{{ $role->name }}</h1>			
		</div>
		<form action="{{ route('editRolesAdmin',['id'=>$role->id]) }}" method="POST" name="editRole" class="edit-form">
			{{ csrf_field() }}
			<div id="frm-name" class="form-group section">
				<label for="name">{{ _('Name') }}<small>(*)</small></label>
				<input type="text" name="name" class="form-control" value="{{ $role->name }}">
			</div>
			<div class="form-group checkbox ">
                <h4 class="title">{{ __('Permissions') }}</h4>
                @if($permissions)
                    @foreach($permissions as $key => $group)
                        <div class="list-item mb-2 ml-4 check__checkbox_all">
                            <div class="icheck-primary mb-0">
                                <input type="checkbox" id="checkbox_{{ $key }}" class="parent-check">
                                <label for="checkbox_{{ $key }}">{{ $key }}</label>
                                <a href="javascript:void(0);" class="toggle-cs ml-2"><i class="fa fa-angle-right"></i></a>
                            </div>
                            <div class="list-child ml-4 pl-4">
                                @foreach($group as $stt => $item)
                                    <div class="icheck-success">
                                        <input type="checkbox" name="permissions[]" id="checkbox_{{ $key.'_'.$stt }}" value="{{ $item->name }}"{{ $role->hasPermissionTo($item->name) ? ' checked' : '' }}>
                                        <label for="checkbox_{{ $key.'_'.$stt }}">{{ $item->display_name != null ? $item->display_name : explode('.',$item->name)[1] }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
			<div class="group-action">
				<a href="{{ route('deleteRolesAdmin',['id'=>$role->id]) }}" class="btn btn-delete">{{ _('Xoá') }}</a>
				<button type="submit" class="btn">{{ _('Lưu') }}</button>
				<a href="{{ route('rolesAdmin') }}" class="btn btn-cancel">{{ _('Huỷ') }}</a>
			</div>
			</form>
		</div>
	
@endsection