@php
/*
* table content of chaps
* @param request : $list_chap
*/
@endphp
<table class="table table-striped list">
	<thead class="thead-dark">
		<tr>
			<th class="chap">{{ _('Chương') }}</th>
			<th class="short-chap">{{ _('Chương rút gọn') }}</th>
			<th class="title">{{ _('Tên chương') }}</th>
			<th class="date">{{ _('Ngày tạo') }}</th>
			<th class="action">{{ _('Tác vụ') }}</th>
		</tr>
	</thead>
	<tbody class="sortable" data-action="{{ route('postionChapAdmin',[$comic->id , $book->id]) }}">
		@if ($list_chap->isNotEmpty())
			@foreach($list_chap as $key => $item)
				<tr id="item-{{ $item->id }}" class="ui-state-default" data-value="{{ $item->id }}" data-position="{{ $item->position }}">
					<td class="chap"><a href="{{ route('editChapAdmin', ['comic_id'=>$comic->id,'book_id'=>$book->id, 'id'=>$item->id]) }}">{{ $item->chap }}</a></td>
					<td class="short-chap">{{ $item->short_chap }}</td>
					<td class="title">{{ $item->title }}</td>
					<td class="date">{{ customDateConvert($item->created_at) }}</td>
					<td class="action">
						<a href="{{ route('detailChap',['slugComic'=>$book->slug,'slugChap'=>$item->slug]) }}" target="_blank" class="front-end"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
						<a href="{{ route('editChapAdmin', ['comic_id'=>$comic->id,'book_id'=>$book->id, 'id'=>$item->id]) }}" class="edit" title="edit"><i class="fal fa-edit"></i></a>
						<a href="{{ route('deleteChapAdmin', ['comic_id'=>$comic->id,'book_id'=>$book->id, 'id'=>$item->id]) }}" class="btn-delete delete" title="delete"><i class="fal fa-times"></i></a>
						@handheld <a href="javascript:void(0);" class="view"><i class="fal fa-eye"></i></a> @endhandheld
					</td>
				</tr>
			@endforeach
		@endif
	</tbody>
</table>
