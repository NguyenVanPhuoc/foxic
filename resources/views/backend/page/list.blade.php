@extends('backend.layout.index')
@section('title','Trang')
@section('content')
	<div id="pages" class="page">
		<div class="head container"><h1 class="title">{{ _('Tất cả trang') }}</h1></div>
		<form id="page-frm" action="#" method="post" name="page" class="dev-form" data-delete="{{route('deletePagesAdmin')}}">
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
							<th class="title">{{ _('Tên trang') }}</th>
							<th class="slug hidden-667">{{ _('Slug') }}</th>
							<th class="author">{{ _('Tác giả') }}</th>
							<th class="date hidden-1024">{{ _('Ngày tạo') }}</th>
							<th class="action">{{ _('Tác vụ') }}</th>
						</tr>
					</thead>
					<tbody>					
						@foreach($pages as $page)
							@php $user = getUser($page->user_id); @endphp
							<tr id="item-{{ $page->id }}">
								<td class="check">
									<div class="checkbox checkbox-success">
										<input id="page-{{$page->id}}" type="checkbox" name="page[]" value="{{$page->id}}">
										<label for="page-{{$page->id}}"></label>
									</div>
								</td>							
								<td class="title"><a href="{{ route('editPageAdmin',['id'=>$page->id]) }}">{{ $page->title }}</a></td>
								<td class="slug hidden-667">{{ $page->slug }}</td>
								<td class="author">@if($user != null){{ $user->name }}@endif</td>
								<td class="date hidden-1024">{{ $page->updated_at }}</td>
								<td class="action">
									<a href="{{getPage($page->slug)}}" target="_blank" class="front-end"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
									<a href="{{ route('editPageAdmin',['id'=>$page->id]) }}" class="edit"><i class="fal fa-edit"></i></a>
									<a href="{{ route('deletePageAdmin',['id'=>$page->id]) }}" class="delete btn-delete"><i class="fal fa-times"></i></a>
									@handheld<a href="javascript:void(0);" class="view"><i class="fal fa-eye"></i></a>@endhandheld
								</td>
							</tr>
							@handheld
								<tr class="item-{{$page->id}} info-detail">
									<td colspan="8">
										<div class="box">
											<ul class="list-unstyled">
												<li>{{ _('Tên trang') }}: <strong>{{ $page->title }}</strong></li>
												<li>{{ _('Slug') }}: <strong>{{ $page->slug }}</strong></li>
												<li>{{ _('Tác giả') }}: <strong>@if($user != null){{ $user->name }}@endif</strong></li>
												<li>{{ _('Ngày tạo') }}: <strong>{{ $page->updated_at }}</strong></li>
											</ul>
											<a href="{{ route('editPageAdmin',['id'=>$page->id]) }}" class="read-more"><i class="fal fa-angle-right"></i>{{ _('Chi tiết') }}</a>
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
	{!! $pages->links() !!}
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