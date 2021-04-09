@extends('templates.master')
@section('title','Thư viện')
@section('content')
<div id="list-media" class="page profile media">
	<div class="container">
		<div id="pro-main" class="row">
			<div id="sidebar" class="sb-left col-md-3">@include('sidebars.member')</div>
			<div id="main" class="col-md-9">	
				@include('members.profile_header')
				<ul class="pro-menu">
					<li><a href="{{ route('mediaProfile') }}" class="active">Tất cả</a></li>
					<li><a href="{{ route('storeMediaProfile') }}">Thêm mới</a></li>
				</ul>
				<form id="media-frm" action="{{route('deleteMediasProfile')}}" method="post" name="media" class="dev-form">
					{{ csrf_field() }}
					<div class="main-wrap">
						<table class="table table-striped">
							<thead>
								<tr>
									<th id="check-all" scope="col" class="check">
										<div class="checkbox checkbox-success">
											<input id="check" type="checkbox" name="checkAll[]" value="">
											<label for="check"></label>
										</div>
									</th>
									<th scope="col" class="stt">STT</th>
									<th scope="col" class="image hidden-384">Hình ảnh</th>
									<th scope="col" class="title">Tên file</th>
									<th scope="col" class="date hidden-600">Ngày</th>
									<th scope="col" class="action">Tác vụ</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($media))
									@php $count = 0;@endphp
									@foreach($media as $item) @php $count++; $title = empty($item->title)? $item->image_path : $item->title;@endphp
										<tr id="image-{{ $item->id }}">
											<td class="check">
												<div class="checkbox checkbox-success">
													<input id="media-{{$item->id}}" type="checkbox" name="medias[]" value="{{$item->id}}">
													<label for="media-{{$item->id}}"></label>
												</div>
											</td>
											<td scope="row" class="stt">{{ $count }}</td>
											<td class="image hidden-384">{!!image($item->id, 100,60, $item->title)!!}</td>
											<td class="title">{{ $title }}</td>
											<td class="date hidden-600">{{$item->created_at}}</td>
											<td class="action">
												<a href="{{route('editMediaProfile',['id'=>$item->id])}}" class="edit">
													<img src="{{asset('public/images/edit.png')}}" alt="icon" class="not-hover">
													<img src="{{asset('public/images/edit-white.png')}}" alt="icon" class="hover">
												</a>
												<a href="{{route('deleteMediaProfile',['id'=>$item->id])}}" class="delete">
													<img src="{{asset('public/images/remove.png')}}" alt="icon" class="not-hover">
													<img src="{{asset('public/images/remove-white.png')}}" alt="icon" class="hover">
												</a>
												@handheld<a href="javascript:void(0);" class="view"><i class="fa fa-eye" aria-hidden="true"></i></a>@endhandheld
											</td>
										</tr>
										@handheld
											<tr class="image-{{$item->id}} info-detail">
												<td colspan="6">
													<div class="box">
														<ul class="list-unstyled">
															<li>Tên file: <strong>{{ $title }}</strong></li>
															<li>Ngày: <strong>{{$item->created_at}}</strong></li>
														</ul>
														<a href="{{ route('editMediaProfile',['id'=>$item->id]) }}" class="read-more"><i class="fa fa-angle-right" aria-hidden="true"></i>Chi tiết</a>
													</div>					
												</td>
											</tr>
										@endhandheld
									@endforeach
								@else
									<tr><td colspan="6">Chưa có file nào...</td></tr>
								@endif			
							</tbody>
						</table>
						<div class="page-nav">
							{!! $media->links() !!}
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	@include('media.library')
</div>
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