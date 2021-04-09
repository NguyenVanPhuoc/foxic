@foreach($lists as $key => $item)
	@if($key<5)
		<a href="{{ route('listChap',$item->slug).'/' }}" title="{{ $item->showTitle() }}">{{ $item->showTitle() }}</a>
	@endif	
@endforeach
@if(count($lists)>1)
	<a href="{{ route('searchComic').'?keyword='.$keyword }}" class="more">{{ _('Xem thêm kết quả khác ') }}<i class="fa fa-search"></i></a>
@endif

