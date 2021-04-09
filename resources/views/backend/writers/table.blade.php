@php
/*
* table content of writer
*/
@endphp
<table class="table table-striped list">
	<thead class="thead-dark">
		<tr>
			@can('users.safe')
			<th id="check-all" class="check">
				<div class="checkbox checkbox-success">
					<input id="check" type="checkbox" name="checkAll[]" value="">
					<label for="check"></label>
				</div>
			</th>
			@endcan
			<th class="stt">{{ _('STT') }}</th>
			<th class="title">{{ _("Tên tác giả") }}</th>
			<th class="action">{{ _('Tác vụ') }}</th>
		</tr>
	</thead>
	<tbody>
		@if ($list_writer->isNotEmpty())
			@foreach($list_writer as $key => $item)
				<tr id="item-{{ $item->id }}">
					@can('users.safe')
					<td class="check">
						<div class="checkbox checkbox-success">
							<input id="comicWriter-{{ $item->id }}" type="checkbox" name="comicWriters[]" value="{{ $item->id }}">
							<label for="comicWriter-{{ $item->id }}"></label>
						</div>
					</td>
					@endcan
					<td>{{ $key + 1 }}</td>
					<td class="title"><a href="{{ route('editWriterAdmin', $item->id) }}">{{ $item->show_name() }}</a></td>
					<td class="action">
						<a href="{{ route('editWriterAdmin', $item->id) }}" class="edit"><i class="fal fa-edit"></i></a>
						<a href="{{ route('deleteWriterAdmin', $item->id) }}" class="btn-delete delete"><i class="fal fa-times"></i></a>
						@handheld<a href="javascript:void(0);" class="view"><i class="fal fa-eye"></i></a>@endhandheld
					</td>
				</tr>
			@endforeach
		@endif
	</tbody>
</table>

@if(isset($keyword) && $keyword != "")
	{!! $list_writer->setPath(route('writersAdmin'))->appends(['s'=>$keyword])->links() !!}
@else
	{!! $list_writer->setPath(route('writersAdmin'))->links() !!}
@endif