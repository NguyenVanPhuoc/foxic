@php
    $readings = getReadingChaps();
@endphp
@if(count($readings) > 0)
    <aside id="sb-history" class="sb-comic">
        <div class="sb-title">
            <h3>{{ _('Truyện đang đọc') }}</h3>
        </div>
        <div class="list-history list">
            @foreach ($readings as $item)
                @if($item->count() > 0)
                    <div class="item row">
                        <div class="comic-title col-md-7">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                            <h4><a href="{{ route('listChap',$item->comic_slug).'/' }}" title="{{ $item->comic_title }}">{{ $item->comic_title }}</a></h4>
                        </div>
                        <div class="comic-chap col-md-5">
                            <a href="{{ route('detailChap',['slugComic'=>$item->comic_slug,'slugChap'=>$item->slug_chap]).'/' }}" title="{{ $item->comic_title.' - '.$item->short_chap }}">{{ 'Đọc tiếp '.$item->short_chap }}</a>
                        </div>
                    </div>
                @endif    
            @endforeach
        </div>
    </aside>
@endif    
<aside id="sb-type" class="sb-comic">
    <div class="sb-title">
        <h3>{{ _('Thể loại truyện') }}</h3> 
    </div>
    <div class="list-type row">
        @php $typeComics = getListTypeComic();@endphp
        @foreach ($typeComics as $type)
            <div class="item col-md-6"> 
                <a href="{{ route('typeChap',['slug'=>$type->slug]).'/' }}" >{{ $type->title }}</a>
            </div>
        @endforeach
       
    </div>
</aside>