@php
/*
* table content of categories
*/
@endphp
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
			<th class="image">{{ __('Ảnh đại diện') }}</th>
			<th class="title">{{ __('Tên thanh toán') }}</th>
			<th>{{ __('Mô tả') }}</th>
			<th class="action">{{ __('Tác vụ') }}</th>
		</tr>
	</thead>
	<tbody>
		@if ($cates->isNotEmpty())
			@foreach($cates as $key => $item)
				<tr id="item-{{ $item->id }}">
					<td class="check">
						<div class="checkbox checkbox-success">
							<input id="comicCat-{{ $item->id }}" type="checkbox" name="comicCats[]" value="{{ $item->id }}">
							<label for="comicCat-{{ $item->id }}"></label>
						</div>
					</td>
					<td>{{ $key + 1 }}</td>
					<td class="image">{!! image($item->image, 50, 50, $item->title) !!}</td>
					<td class="title"><a href="{{ route('editCatPaymentAdmin', $item->id) }}">{{ $item->title }}</a></td>
					<td>{!! $item->description !!}</td>
					<td class="action">
						<a href="{{ route('editCatPaymentAdmin', $item->id) }}" class="edit"><i class="fal fa-edit"></i></a>
						<a href="{{ route('deleteCatPaymentAdmin', $item->id) }}" class="delete btn-delete"><i class="fal fa-times"></i></a>
						@handheld<a href="javascript:void(0);" class="view"><i class="fal fa-eye"></i></a>@endhandheld
					</td>
				</tr>
			@endforeach
		@endif
	</tbody>
</table>
@if(isset($keyword) && $keyword != "")
    {{ $cates->appends(['s'=>$keyword])->links() }}
 @else
    {{ $cates->links() }}
 @endif