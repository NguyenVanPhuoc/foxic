@if($object)
	<div class="list-item">
	@foreach($object as $item)
		<a href="#{{$item->slug}}" data-value="{{$item->id}}">{{$item->title}}</a>
	@endforeach
	</div>
	{!! $object->render() !!}
@endif