@php
/*
* Template list item media
* @param request : $list_media
*/
@endphp
@if(isset($list_media))
	@foreach($list_media as $media)
		@php
			$path = url('/').'/image/'.$item->image_path.'/150/100';
		@endphp
		<li id="image-{{ $media->id }}">
			<div class="wrap">
				<img src="{{ $path }}" alt="papc-new.png" data-date="{{ $item->updated_at }}" data-image="{{ url('public/uploads').'/'.$item->image_path }}" />
			</div>
		</li>
	@endforeach
@endif