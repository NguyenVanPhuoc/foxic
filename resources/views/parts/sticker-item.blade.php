@if($sticker)
	<li><a href="{{ $sticker->id }}" class="choose-sticker">{!! $sticker->show_sticker(55,55) !!}</a></li>
@endif