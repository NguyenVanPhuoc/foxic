@extends('backend.layout.index')
@section('title','Roles')
@section('content')
	<div id="roles" class="page">
		<div class="head container"><h1 class="title">{{ _('Tất cả') }}</h1></div>
		<form id="page-frm" action="#" method="post" name="page" class="dev-form" data-delete="{{route('deleteRolesAdmin')}}">
				{{ csrf_field() }}
			<div class="table-responsive">
				<table class="table table-striped list-page">
					<thead>
						<tr>
							<th id="check-all" scope="col" class="check">
								<div class="checkbox checkbox-success">
									<input id="check" type="checkbox" name="checkAll" value="">
									<label for="check"></label>
								</div>
							</th>						
							<th class="title">{{ _('Name') }}</th>
							<th class="slug">{{ _('Guard name') }}</th>
							<th class="action">{{ _('Actions') }}</th>
						</tr>
					</thead>
					<tbody>					
						@foreach($roles as $role)
							<tr id="item-{{ $role->id }}">
								<td class="check">
									<div class="checkbox checkbox-success">
										<input id="role-{{$role->id}}" type="checkbox" name="role[]" value="{{$role->id}}">
										<label for="role-{{$role->id}}"></label>
									</div>
								</td>							
								<td class="title"><a href="{{ route('editRolesAdmin',['id'=>$role->id]) }}">{{ $role->name }}</a></td>
								<td class="slug">{{ $role->guard_name }}</td>
								
								<td class="action">
									<a href="{{ route('editRolesAdmin',['id'=>$role->id]) }}" class="edit"><i class="fal fa-edit"></i></a>
									<!-- <a href="{{ route('deleteRoleAdmin',['id'=>$role->id]) }}" class="delete btn-delete"><i class="fal fa-times"></i></a> -->
								</td>
							</tr>
							
						@endforeach
					</tbody>
				</table>
			</div>
		</form>
	</div>
	{!! $roles->links() !!}
	
@endsection