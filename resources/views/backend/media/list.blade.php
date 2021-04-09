@extends('backend.layout.index')
@section('title','Thư viên ảnh')
@section('content')
	<div id="media" class="page">
		<div class="head"><h1 class="title">{{ _('Thư viên ảnh') }}</h1></div>
		<form id="media-frm" action="#" method="post" name="media" class="dev-form" data-delete="{{ route('deleteAllMedia') }}">
			{{ csrf_field() }}
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th id="check-all" class="check">
								<div class="checkbox checkbox-success">
									<input id="check" type="checkbox" name="checkAll[]" value="">
									<label for="check"></label>
								</div>
							</th>						
							<th class="image">{{ _('Ảnh') }}</th>
							<th class="title">{{ _('Tên ảnh') }}</th>
							<th class="category hidden-568">{{ _('Danh mục') }}</th>
							<th class="author hidden-568">{{ _('Tác giả') }}</th>
							<th class="date hidden-1024">{{ _('Ngày tạo') }}</th>
							<th class="action">{{ _('Tác vụ') }}</th>
						</tr>
					</thead>
					<tbody>
						@if(isset($media))						
							@foreach($media as $item)
							@php $user = getUser($item->user_id); @endphp
							<tr id="item-{{ $item->id }}">
								<td class="check">
									<div class="checkbox checkbox-success">
										<input id="media-{{ $item->id }}" type="checkbox" name="medias[]" value="{{ $item->id }}">
										<label for="media-{{ $item->id }}"></label>
									</div>
								</td>							
								<td class="image">{!! image($item->id,100,60,$item->title) !!}</td>
								<td class="title">{{ $item->title }}</td>	
								<td class="category hidden-568">
									@if($item->cat_ids)
										<?php $number = 0;
										$cats = explode(',',$item->cat_ids);
										foreach ($cats as $value) {
											$number ++;
											$cat = getMediaCat($value);
											if($cat) echo $cat->title;
											if($number < count($cats)) echo ', ';
										}?>
									@endif
								</td>
								<td class="author hidden-568">{{ isset($user->name) && $user->name != null ? $user->name : ''}}</td>
								<td class="date hidden-1024">{{$item->created_at}}</td>
								<td class="action">
									<a href="{{ route('editMedia',['id'=>$item->id]) }}" class="edit"><i class="fal fa-edit"></i></a>
									<a href="{{ route('deleteMedia',['id'=>$item->id]) }}" class="btn-delete delete"><i class="fal fa-times"></i></a>
									@handheld<a href="javascript:void(0);" class="view"><i class="fal fa-eye"></i></a>@endhandheld
								</td>
							</tr>
							@handheld
								<tr class="item-{{$item->id}} info-detail">
									<td colspan="8">
										<div class="box">
											<ul class="list-unstyled">
												<li>Tên file: <strong>{{$item->title}}</strong></li>
												<li>Danh mục: 
													<strong>
														@if ($item->cat_ids)
															@php $number = 0;
															$cats = explode(',', $item->cat_ids);
																foreach($cats as $value){
																	$number ++;
																	$cat = getMediaCat($value);
																	if($cat) echo $cat->title;	
																	if($number < count($cats)) echo ', ';
																}
															@endphp
														@endif
													</strong>
												</li>
												<li>Tác giả: <strong>@if($user->name != NULL){{ $user->name }}@endif</strong></li>
												<li>Ngày tạo: <strong>{{$item->created_at}}</strong></li>
											</ul>
											<a href="{{ route('editMedia',['id'=>$item->id]) }}" class="read-more"><i class="fal fa-angle-right"></i>Chi tiết</a>
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
			</div>
		</form>
	</div>
	{!! $media->links() !!}
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