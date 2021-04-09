@php
/*
* Template list item media
* @param request : $list_media
*/
@endphp
@if(isset($list_media))
	@foreach($list_media as $media)
		@php
			$path = url('/').'/image/'.$media->image_path.'/150/100';
		@endphp
		<li id="image-{{ $media->id }}">
			<div class="wrap">
				<img src="{{ $path }}" alt="{{ $media->title }}" data-date="{{ $media->updated_at }}" data-image="{{ url('public/uploads').'/'.$media->image_path }}" data-title="{{ $media->title }}" />
			</div>
		</li>
	@endforeach
@elseif(isset($list_oldMedia))
	@foreach($list_oldMedia as $media)
		@php
			$path = url('/').'/image/'.$media->image_path.'/150/100';
		@endphp
		<li id="image-{{ $media->id }}">
			<div class="wrap">
				<img src="{{ $path }}" alt="{{ $media->title }}" data-date="{{ $media->updated_at }}" data-image="{{ url('public/uploads').'/'.$media->image_path }}" data-title="{{ $media->title }}" />
			</div>
		</li>
	@endforeach
@endif