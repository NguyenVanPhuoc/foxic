@php
/*
* table content of writer
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
			<th class="title">{{ _("Tên") }}</th>
			<th class="title">{{ _("Loại") }}</th>
			<th class="action">{{ _('Tác vụ') }}</th>
		</tr>
	</thead>
	<tbody>
		@if ($list_vote->isNotEmpty())
			@foreach($list_vote as $key => $item)
				<tr id="item-{{ $item->id }}">
					<td class="check">
						<div class="checkbox checkbox-success">
							<input id="comicWriter-{{ $item->id }}" type="checkbox" name="comicWriters[]" value="{{ $item->id }}">
							<label for="comicWriter-{{ $item->id }}"></label>
						</div>
					</td>
					<td>{{ $key + 1 }}</td>
					<td class="title"><a href="{{ route('editVoteAdmin', $item->id) }}">{{ $item->title }}</a></td>
					<td class="title">{{ $item->choose_point == 0 ? "Xu" : "Point" }}</td>
					<td class="action">
						<a href="{{ route('editVoteAdmin', $item->id) }}" class="edit"><i class="fal fa-edit"></i></a>
						<a href="{{ route('deleteVoteAdmin', $item->id) }}" class="btn-delete delete"><i class="fal fa-times"></i></a>
					</td>
				</tr>
			@endforeach
		@endif
	</tbody>
</table>