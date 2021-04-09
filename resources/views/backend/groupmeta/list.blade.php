@extends('backend.layout.index')
@section('title','Group Meta')
@section('content')
<div id="mediaFields" class="page media-fields">
	<div class="head"><h1 class="title">Meta fields</h1></div>
	{{-- @if(count($errors)>0)
	<div class="alert alert-danger">
		<ul>
			@foreach($errors->all() as $error)
			<li>{{$error}}</li>	
			@endforeach
		</ul>
	</div>
	@endif
	@if(session('success'))
	<div class="alert alert-success">{{session('success')}}</div>
	@endif --}}
	<form id="group-meta" action="#" method="post" name="addGroupMeta" class="dev-form groupMeta">
		{{ csrf_field() }}
		<div class="table-responsive">
			
			<table id="list-members" class="table table-striped">
				<thead>
					<tr>
						<th scope="col" class="stt">STT</th>
						<th scope="col" class="title">Tên nhóm</th>
						<th scope="col" class="type">Đối tượng</th>
						<th scope="col" class="date hidden-768">Ngày tạo</th>
						<th scope="col" class="action">Tác vụ</th>
					</tr>
				</thead>
				<tbody>
					<?php $count = 0;?>
					@foreach($groupMetas as $group) <?php $count++; $page = getPageMetas($group->post_id); ?>	
					<tr id="item-{{ $group->id }}">
						<td class="stt">{{ $count }}</td> 
						<td class="title">{{$group->title}}</td>
						<td class="type">@if($page!=null) {{ $page->title }} @endif</td>
						<td class="date hidden-768">@if($page!=null){{ $group->created_at }} @endif</td>
						<td class="action">
							<a href="{{ route('editMeta',['id'=>$group->id]) }}" class="edit"><i class="fal fa-edit" aria-hidden="true"></i></a>
							<a href="{{ route('deleteGroupMeta',['id'=>$group->id]) }}" class="btn-delete delete"><i class="fal fa-times" aria-hidden="true"></i></a>
							@handheld<a href="javascript:void(0);" class="view show-768"><i class="fal fa-eye" aria-hidden="true"></i></a>@endhandheld	
						</td>
					</tr>
						@handheld
							<tr class="item-{{ $group->id }} info-detail show-768">
								<td colspan="5">
									<div class="box">
										<ul class="list-unstyled">
											<li>Tên nhóm: <strong>{{$group->title}}</strong></li>
											<li>Đối tượng: <strong>@if($page!=null) {{$page->title}} @endif</strong></li>
											<li>Ngày tạo: <strong>@if($page!=null){{$group->created_at}} @endif</strong></li>
										</ul>
										<a href="{{ route('editMeta',['id'=>$group->id]) }}" class="read-more"><i class="fa fa-angle-right" aria-hidden="true"></i>Chi tiết</a>
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
{!! $groupMetas->links() !!}
	<div class="modal delete-modal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Thông báo</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Bạn chắc là muốn xóa nhóm này.</p>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn btn-primary">Đồng ý</a>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
				</div>
			</div>
		</div>
	</div>
@endsection