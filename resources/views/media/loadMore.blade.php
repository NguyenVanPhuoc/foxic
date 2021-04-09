@if(count($media)>0)
  @foreach ($media as $item)
    <?php $path = url('/').'/image/'.$item->image_path.'/150/100';?>
    <li id="image-{{$item->id}}">
    	<div class="wrap"><img src="{{$path}}" alt="{{$item->image_path}}" data-date="{{$item->updated_at}}" data-image="{{url('public/uploads')}}/{{$item->image_path}}" /></div>
    </li>
  @endforeach
@endif