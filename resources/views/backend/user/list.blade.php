@extends('backend.layout.index')
@section('title','Thành viên')
@section('content')
	@php
		$role = isset($role)? $role:'';
		$key = isset($s)? $s:'';
	@endphp
	<div id="users" class="page p-user">
		<div class="head">
			<a href="{{ route('users') }}" class="back-icon"><i class="fal fa-angle-left"></i> {{ _('Tất cả') }}</a>
			<h1 class="title">{{ _('Thành viên') }}</h1>
		</div>
		<div class="row search-filter">
			<div class="col-md-6 col-sm-6 col-xs-6 frm-search">
				<div class="search-form">
					<form name="s" action="{{ route('users') }}" method="GET">
						<input type="text" name="s" class="form-control" placeholder="Nhập tên thành viên..." value="{{ $key }}">
						<input type="hidden" name="role" value="{{ $role }}">
						<button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>
					</form>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6 filter">
				<ul class="nav-filter">
					<li @if($role=="") class="active" @endif><a href="{{ route('users') }}?s={{ $key }}">{{ _('Tất cả') }}</a></li>
					<li @if($role=="BQT") class="active" @endif><a href="{{ route('users') }}?role=BQT&s={{ $key }}">{{ _('BQT') }}</a></li>
					<li @if($role=="Kiểm duyệt viên") class="active" @endif><a href="{{ route('users') }}?role=Kiểm duyệt viên&s={{ $key }}">{{ _('Người kiểm duyệt') }}</a></li>
					<li @if($role=="Tác giả") class="active" @endif><a href="{{ route('users') }}?role=Tác giả&s={{ $key }}">{{ _('Biên tập viên') }}</a></li>
					<li @if($role=="Độc giả") class="active" @endif><a href="{{ route('users') }}?role=Độc giả&s={{ $key }}">{{ _('Thành viên') }}</a></li>
				</ul>
			</div>
		</div>
		<form id="customers" action="#" method="post" name="addUser" class="dev-form list-user" data-delete="{{ route('deleteUsersAdmin') }}">
			{{ csrf_field() }}
			<div class="tb-results table-responsive">
				<table id="list-members" class="table table-striped">
					<thead class="thead-dark">
						<tr>
							<th id="check-all" class="check">
								<div class="checkbox checkbox-success">
									<input id="check" type="checkbox" name="checkAll[]" value="">
									<label for="check"></label>
								</div>
							</th>							
							<th class="avatar hidden-375">{{ _('Ảnh đại diện') }}</th>
							<th class="title">{{ _('Họ tên') }}</th>
							<th class="phone hidden-768">{{ _('Số điện thoại') }}</th>
							<th class="email hidden-991">{{ _('Email') }}</th>
							<th class="date hidden-1024">{{ _('Ngày tạo') }}</th>
							<th class="role hidden-424">{{ _('Phân quyền') }}</th>
							<th class="role hidden-424">{{ _('Số point') }}</th>
							<th class="role hidden-424">{{ _('Số tiền') }}</th>
							<th class="action">{{ _('Tác vụ') }}</th>
						</tr>
					</thead>
					<tbody>						
						@foreach($users as $u)							
						<tr id="item-{{ $u->id }}">
							<td class="check">
								<div class="checkbox checkbox-success">
									<input id="user-{{ $u->id }}" type="checkbox" name="users" value="{{ $u->id }}">
									<label for="user-{{ $u->id }}"></label>
								</div>
							</td>							
							<td class="avatar hidden-375"><a href="{{ route('updateAdmin',['id'=>$u->id]) }}">{!! image($u->image,50,50,$u->name) !!}</a></td>
							<td class="title"><a href="{{ route('updateAdmin',['id'=>$u->id]) }}">{{ $u->name }}</a></td>
							<td class="phone hidden-768">{{ $u->phone }}</td>
							<td class="email hidden-991">{{ $u->email }}</td>
							<td class="date hidden-1024">{{ $u->updated_at }}</td>
							<td class="level hidden-424">{!! isset($u->roles->first()->name) ? $u->roles->first()->name : 'NULL' !!}</td>
							<td class="level hidden-424">{{ $u->point }}</td>
							<td class="level hidden-424">
								@if($u->type_author == 'official')
								<span class="author">{{number_format($u->point * 700, 0, '.', '.')}} VND</span>
								@elseif($u->type_author == 'unofficial')
								<span class="author">{{number_format($u->point * 500, 0, '.', '.')}} VND</span>
								@elseif($u->type_author == 'unrestrained')
								<span class="author">{{number_format($u->point * 300, 0, '.', '.')}} VND</span>
								@endif
							</td>							
							<td class="action">
								<a href="{{ route('updateAdmin',['id'=>$u->id]) }}" class="edit"><i class="fal fa-edit"></i></a>
								<a href="{{ route('deleteAdmin',['id'=>$u->id]) }}" class="delete btn-delete"><i class="fal fa-times"></i></a>
								@handheld<a href="javascript:void(0);" class="view"><i class="fal fa-eye"></i></a>@endhandheld
							</td>
						</tr>
							@handheld
							<tr class="item-{{ $u->id }} info-detail">
								<td colspan="10">
									<div class="box">
										<ul class="list-unstyled">
											<li>{{ _('Họ tên') }}: <strong><a href="{{ route('updateAdmin',['slug'=>$u->slug]) }}">{{ $u->name }}</a></strong></li>
											<li>{{ _('Số điện thoại') }}: <strong>{{ $u->phone }}</strong></li>
											<li>{{ _('Email') }}: <strong>{{ $u->email }}</strong></li>
											<li>{{ _('Phân quyền') }}: <strong>{!! isset($u->roles->first()->name) ? $u->roles->first()->name : 'NULL' !!}</strong></li>
											<li>{{ _('Ngày tạo') }}: <strong>{{ $u->updated_at }}</strong></li>
										</ul>
										<a href="{{ route('updateAdmin',['slug'=>$u->id]) }}" class="read-more"><i class="fal fa-angle-right"></i>{{ _('Chi tiết') }}</a>
									</div>
								</td>
							</tr>
							@endhandheld
						@endforeach
					</tbody>
				</table>
			</div>
		</form>
	</div>
	@if($role=="" && $key=="")
		{!! $users->links() !!}
	@else
		{!! $users->appends(['role'=>$role,'s'=>$key])->links() !!}		
	@endif
	@if(session('success'))
		<script type="text/javascript">
			$(function(){
				new PNotify({
					title: 'Thành công',
					text: 'Xóa Thành công.',
					type: 'success',
					hide: true,
					delay: 2000,
				});
			})
		</script>
	@endif
@endsection