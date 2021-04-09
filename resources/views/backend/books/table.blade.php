@php
/*
* table content of chaps
* @param request : $list_book
*/
@endphp
<table class="table table-striped list">
	<thead class="thead-dark">
		<tr>
			<th class="title">{{ _('Tên quyển') }}</th>
			<th class="title">{{ _('slug') }}</th>
			<th class="date">{{ _('Ngày tạo') }}</th>
			<th class="action">{{ _('Tác vụ') }}</th>
		</tr>
	</thead>
	<tbody class="sortable" data-action="{{ route('postionBookAdmin', $comic->id) }}">
		@if ($list_book->isNotEmpty())
			@foreach($list_book as $key => $item)
				<tr id="item-{{ $item->id }}" class="ui-state-default" data-value="{{ $item->id }}" data-position="{{ $item->position }}">
					<td class="title"><a href="{{ route('editBookAdmin', ['comic_id'=>$comic->id, 'id'=>$item->id]) }}">{{ $item->title }}</a></td>
					<td class="title">{{ $item->slug }}</td>
					<td class="date">{{ customDateConvert($item->created_at) }}</td>
					<td class="action">
						<a href="{{ route('editBookAdmin', ['comic_id'=>$comic->id, 'id'=>$item->id]) }}" class="edit" title="edit"><i class="fal fa-edit"></i></a>
						<a href="{{ route('chapsAdmin',['comic_id'=>$comic->id, 'id'=>$item->id]) }}" title="All chaps"><i class="fal fa-file-signature"></i></a>
						<a href="{{ route('deleteBookAdmin', ['comic_id'=>$comic->id, 'id'=>$item->id]) }}" class="btn-delete delete" title="delete"><i class="fal fa-times"></i></a>
						@handheld <a href="javascript:void(0);" class="view"><i class="fal fa-eye"></i></a> @endhandheld
					</td>
				</tr>
			@endforeach
		@endif
	</tbody>
</table>
