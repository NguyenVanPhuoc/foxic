<table class="table table-striped list">
	<thead class="thead-dark">
		<tr>
			<th id="check-all" class="check">
				<div class="checkbox checkbox-success">
					<input id="check" type="checkbox" name="checkAll[]" value="">
					<label for="check"></label>
				</div>
			</th>
			<th class="stt">{{ __('STT') }}</th>
			<th>{{ __('Ảnh đại diện') }}</th>
			<th class="title">{{ __('Tiêu đề') }}</th>
			<th class="author">{{ __('Thòi gian') }}</th>
			<th class="action">{{ __('Tác vụ') }}</th>
		</tr>
	</thead>
	<tbody>
		@if($notices->isNotEmpty())
			@foreach($notices as $key => $item)
				@if($item->cate_id)
					@php 
						$cats = $item->cate_id; 
						$cate ='';
						foreach($cats as $keys => $cat_id){
							$cat = get_categories_article($cat_id); 
							$cate .= '<span>'.$cat->title.( $keys != count($cats)-1 ? ', ' : '').'</span>';
						}
					@endphp
				@endif
				<tr id="item-{{ $item->id }}">
					<td class="check">
						<div class="checkbox checkbox-success">
							<input id="notices-{{ $item->id }}" type="checkbox" name="notices[]" value="{{ $item->id }}">
							<label for="notices-{{ $item->id }}"></label>
						</div>
					</td>
					<td>{{ $key + 1 }}</td>
					<td>{!! image($item->image, 50, 50, $item->title) !!}</td>
					<td class="title"><a href="{{ route('editNoticeAdmin', $item->id) }}">{{ $item->title }}</a></td>
					<td class="author">{{ date_format(date_create($item->created_at), 'd-m-Y H:i:s') }}</td>
					<td class="action">
						<a href="{{ route('editNoticeAdmin', $item->id) }}" class="edit"><i class="fal fa-edit"></i></a>
						<a href="{{ route('deleteNoticeAdmin', $item->id) }}" class="delete btn-delete"><i class="fal fa-times"></i></a>
						@handheld<a href="javascript:void(0);" class="view"><i class="fal fa-eye"></i></a>@endhandheld
					</td>
				</tr>
			@endforeach
		@endif
	</tbody>
</table>
@if(isset($keyword) && $keyword != "")
    {{ $notices->appends(['s'=>$keyword])->links() }}
 @else
    {{ $notices->links() }}
 @endif