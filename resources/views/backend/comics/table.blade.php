@php
/*
* table content of comics
* @param request : $list_comic
*/
@endphp
<table class="table table-striped list">
	<thead class="thead-dark">
		<tr>@can('comics.delete')
			<th id="check-all" class="check">
				<div class="checkbox checkbox-success">
					<input id="check" type="checkbox" name="checkAll[]" value="">
					<label for="check"></label>
				</div>
			</th>
			@endcan			
			<th class="image">{{ _('Ảnh đại diện') }}</th>
			<th class="title">{{ _('Tên truyện') }}</th>
			<th class="cat">{{ _('Danh mục') }}</th>
			<th class="type">{{ _('Thể loại') }}</th>
			<th class="writer">{{ _('Tác giả') }}</th>
			<th class="writer">{{ _('Họa sĩ') }}</th>
			<th class="writer">{{ _('Ngày cập nhật') }}</th>
			<th class="title">{{ _('Status') }}</th>
			<th class="action">{{ _('Tác vụ') }}</th>
		</tr>
	</thead>
	<tbody>
		@if ($list_comic->isNotEmpty())
			@foreach($list_comic as $key => $item)
			
				<tr id="item-{{ $item->id }}">
					@can('comics.delete')
					<td class="check">
						<div class="checkbox checkbox-success">
							<input id="comic-{{ $item->id }}" type="checkbox" name="comic[]" value="{{ $item->id }}">
							<label for="comic-{{ $item->id }}"></label>
						</div>
					</td>	
					@endcan	
					<td class="image">{!! image($item->image, 50, 50, $item->showTitle()) !!}</td>
					<td class="title"><a href="{{ route('editComicAdmin', $item->id) }}">{{ $item->showTitle() }}</a></td>
					<td class="cat">{{ getListTextCatInComic($item->id) }}</td>
					<td class="type">{{ getListTextTypeInComic($item->id) }}</td>
					<td class="writer">{{ getListTextWriterInComic($item->id) }}</td>
					<td class="writer">{{ getListTextArtistInComic($item->id) }}</td>
					<td class="writer">{{ date_format(date_create($item->chap_up), 'd-m-Y H:i:s') }}</td>
					<td class="writer btn-status btn {{ $item->status == 'public' ?  'btn-success' : 'btn-primary'}}">{{ $item->status }}</td>					
					<td class="action">
						<a href="{{ route('listChap',$item->slug) }}" target="_blank" class="front-end"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
						<a href="{{ route('booksAdmin', $item->id) }}" title="All books"><i class="fal fa-file-signature"></i></a>
						<a href="{{ route('editComicAdmin', $item->id) }}" class="edit" title="edit"><i class="fal fa-edit"></i></a>
						@can('comics.delete')<a href="{{ route('deleteComicAdmin', $item->id) }}" class="delete btn-delete" title="delete"><i class="fal fa-times"></i></a>@endcan	
					</td>
				</tr>
			@endforeach
		@endif
	</tbody>
</table>

@if(isset($keyword) && $keyword != "")
	{!! $list_comic->setPath(route('comicsAdmin'))->appends(['s'=>$keyword])->links() !!}
@else
	{!! $list_comic->setPath(route('comicsAdmin'))->links() !!}
@endif