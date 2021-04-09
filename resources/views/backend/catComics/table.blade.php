@php
/*
* table content of categories comic
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
			<th class="stt">{{ _('STT') }}</th>
			<th class="image">{{ _('Ảnh đại diện') }}</th>
			<th class="icon">{{ _('Icon') }}</th>
			<th class="title">{{ _('Tên danh mục') }}</th>
			<th class="action">{{ _('Tác vụ') }}</th>
		</tr>
	</thead>
	<tbody>
		@if ($list_cat->isNotEmpty())
			@foreach($list_cat as $key => $item)
				<tr id="item-{{ $item->id }}">
					<td class="check">
						<div class="checkbox checkbox-success">
							<input id="comicCat-{{ $item->id }}" type="checkbox" name="comicCats[]" value="{{ $item->id }}">
							<label for="comicCat-{{ $item->id }}"></label>
						</div>
					</td>
					<td>{{ $key + 1 }}</td>
					<td class="image">{!! image($item->image, 50, 50, $item->showTitle()) !!}</td>
					<td class="icon">{!! image($item->icon, 50, 50, $item->showTitle()) !!}</td>
					<td class="title"><a href="{{ route('editCatComicAdmin', $item->id) }}">{{ $item->showTitle() }}</a></td>
					<td class="action">
						<a href="{{ route('editCatComicAdmin', $item->id) }}" class="edit"><i class="fal fa-edit"></i></a>
						<a href="{{ route('deleteCatComicAdmin', $item->id) }}" class="delete btn-delete"><i class="fal fa-times"></i></a>
						@handheld<a href="javascript:void(0);" class="view"><i class="fal fa-eye"></i></a>@endhandheld
					</td>
				</tr>
			@endforeach
		@endif
	</tbody>
</table>

@if(isset($keyword) && $keyword != "")
	{!! $list_cat->setPath(route('catComicsAdmin'))->appends(['s'=>$keyword])->links() !!}
@else
	{!! $list_cat->setPath(route('catComicsAdmin'))->links() !!}
@endif