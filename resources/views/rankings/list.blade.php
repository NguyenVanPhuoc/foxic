@extends('templates.master')
@section('title', $page->title)
	@if($seo)
		@section('description', $seo->value)
		@section('keywords', $seo->key)
	@endif
@section('content')
    <div id="ranking-page" class="pages">
        @if (Auth::check())
            @include('banners/bannerVip')
        @endif
        <section class="page-content">
            <div class="container">
                <div class="sec-title flex item-center content-between">
                    <h3><img src="{{ asset('public/images/icons/ico_rank.png') }}" alt="{{ _('Ranking') }}">{{ _('Ranking') }}</h3>
                </div>
                <div class="sec-content">
                    <ul id="list-type" class="list-show list-unstyled flex item-center content-between text-center">
                        @if ($types->isNotEmpty())
                            <li class="active"><a href="{{ route('ranking') }}">{{ _('All') }}</a></li>
                            @foreach ($types as $types)
                                <li><a href="{{ route('ranking') }}?type_plus={{ $types->slug }}">{{ $types->title }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                    <div class="list-comics">
                        @if ($comicRatings->isNotEmpty())
                            <div class="inner inner-best row">
                                @php $i = 0; @endphp
                                @foreach ($comicRatings as $comic)
                                    @if ($status == 'off')
                                        @php 
                                            $i ++; 
                                            $typePlusArr = explode(',',$comic->type_plus);
                                            $flag = false;
                                            foreach ($typePlusArr as $type_plus) {
                                                if ($type_plus == '18+') {
                                                    $flag = true;
                                                }
                                            }
                                        @endphp
                                        @if ($flag == true)
                                            @if ($i <= 5)
                                                <div class="item col-md-3">
                                                    <div class="wrap">
                                                        <figure class="image">
                                                            {!! image($comic->image, 270, 400, $comic->title) !!}
                                                            <ul class="status clearfix list-unstyled">
                                                                @php $arrTypePlus = explode(',',$comic->type_plus); @endphp
                                                                @if (count($arrTypePlus) > 0)
                                                                    @foreach ($arrTypePlus as $typePlus)
                                                                        @if ($typePlus) <li class={{ $typePlus }}>{{ $typePlus }}</li> @endif
                                                                    @endforeach
                                                                @endif
                                                            </ul>
                                                            <span class="day">{{ $comic->time_up }}</span>
                                                        </figure>
                                                        <div class="desc">
                                                            <h4 class="title">{{ $comic->title }}</h4>
                                                            @php $listWriters = getArrayTitleWriterInComic($comic->id); @endphp
                                                            <p class="writer">{{ implode(" | ",$listWriters) }}</p>
                                                            <div class="meta-chap flex item-center content-between">
                                                                <ul class="meta list-unstyled flex item-center content-start">
                                                                    @php $listTypes = getObjTitleColorTypeInComic($comic->id); $count = 0;@endphp
                                                                    @foreach ($listTypes as $item)
                                                                        @php $count ++; @endphp
                                                                        <li @if($count > 1) class="active" @endif style="color:{{ $item->color }};">{{ $item->title }}</li>
                                                                    @endforeach
                                                                </ul>
                                                                <span class="chap">{{ getNumLastChapByComicId($comic->id) }}</span>
                                                            </div>
                                                        </div>
                                                        <a href="{{ route('listChap',['slug'=>$comic->slug]) }}" class="read-more"></a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @else
                                        @php 
                                            $i ++; 
                                            $typePlusArr = explode(',',$comic->type_plus);
                                            $flag = false;
                                            foreach ($typePlusArr as $type_plus) {
                                                if ($type_plus == '18+') {
                                                    $flag = true;
                                                }
                                            }
                                        @endphp
                                        @if ($flag == false)
                                            @if ($i <= 5)
                                                <div class="item col-md-3">
                                                    <div class="wrap">
                                                        <figure class="image">
                                                            {!! image($comic->image, 270, 400, $comic->title) !!}
                                                            <ul class="status clearfix list-unstyled">
                                                                @php $arrTypePlus = explode(',',$comic->type_plus); @endphp
                                                                @if (count($arrTypePlus) > 0)
                                                                    @foreach ($arrTypePlus as $typePlus)
                                                                        @if ($typePlus) <li class="{{ $typePlus }}">{{ $typePlus }}</li> @endif
                                                                    @endforeach
                                                                @endif
                                                            </ul>
                                                            <span class="day">{{ $comic->time_up }}</span>
                                                        </figure>
                                                        <div class="desc">
                                                            <h4 class="title">{{ $comic->title }}</h4>
                                                            @php $listWriters = getArrayTitleWriterInComic($comic->id); @endphp
                                                            <p class="writer">{{ implode(" | ",$listWriters) }}</p>
                                                            <div class="meta-chap flex item-center content-between">
                                                                <ul class="meta list-unstyled flex item-center content-start">
                                                                    @php $listTypes = getObjTitleColorTypeInComic($comic->id); $count = 0;@endphp
                                                                    @foreach ($listTypes as $item)
                                                                        @php $count ++; @endphp
                                                                        <li @if($count > 1) class="active" @endif style="color:{{ $item->color }};">{{ $item->title }}</li>
                                                                    @endforeach
                                                                </ul>
                                                                <span class="chap">{{ getNumLastChapByComicId($comic->id) }}</span>
                                                            </div>
                                                        </div>
                                                        <a href="{{ route('listChap',['slug'=>$comic->slug]) }}" class="read-more"></a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                            <div class="inner inner-normal row">
                                @php $i = 0; @endphp
                                @foreach ($comicRatings as $comic) 
                                   @if ($status == 'off')
                                        @php 
                                            $i ++; 
                                            $typePlusArr = explode(',',$comic->type_plus);
                                            $flag = false;
                                            foreach ($typePlusArr as $type_plus) {
                                                if ($type_plus == '18+') {
                                                    $flag = true;
                                                }
                                            }
                                        @endphp
                                        @if ($flag == true)
                                            @if ($i > 5)
                                                <div class="item col-md-3">
                                                    <div class="wrap">
                                                        <figure class="image">
                                                            {!! image($comic->image, 270, 400, $comic->title) !!}
                                                            <ul class="status clearfix list-unstyled">
                                                                @php $arrTypePlus = explode(',',$comic->type_plus); @endphp
                                                                @if (count($arrTypePlus) > 0)
                                                                    @foreach ($arrTypePlus as $typePlus)
                                                                        @if ($typePlus) <li class="{{ $typePlus }}">{{ $typePlus }}</li> @endif
                                                                    @endforeach
                                                                @endif
                                                            </ul>
                                                            <span class="day">{{ $comic->time_up }}</span>
                                                        </figure>
                                                        <div class="desc">
                                                            <h4 class="title">{{ $comic->title }}</h4>
                                                            @php $listWriters = getArrayTitleWriterInComic($comic->id); @endphp
                                                            <p class="writer">{{ implode(" | ",$listWriters) }}</p>
                                                            <div class="meta-chap flex item-center content-between">
                                                                <ul class="meta list-unstyled flex item-center content-start">
                                                                    @php $listTypes = getObjTitleColorTypeInComic($comic->id); $count = 0;@endphp
                                                                    @foreach ($listTypes as $item)
                                                                        @php $count ++; @endphp
                                                                        <li @if($count > 1) class="active" @endif style="color:{{ $item->color }};">{{ $item->title }}</li>
                                                                    @endforeach
                                                                </ul>
                                                                <span class="chap">{{ getNumLastChapByComicId($comic->id) }}</span>
                                                            </div>
                                                        </div>
                                                        <a href="{{ route('listChap',['slug'=>$comic->slug]) }}" class="read-more"></a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @else
                                        @php 
                                            $i ++;
                                            $typePlusArr = explode(',',$comic->type_plus);
                                            $flag = false;
                                            foreach ($typePlusArr as $type_plus) {
                                                if ($type_plus == '18+') {
                                                    $flag = true;
                                                }
                                            }
                                        @endphp
                                        @if ($flag == false)
                                            @if ($i > 5)
                                                <div class="item col-md-3">
                                                    <div class="wrap">
                                                        <figure class="image">
                                                            {!! image($comic->image, 270, 400, $comic->title) !!}
                                                            <ul class="status clearfix list-unstyled">
                                                                @php $arrTypePlus = explode(',',$comic->type_plus); @endphp
                                                                @if (count($arrTypePlus) > 0)
                                                                    @foreach ($arrTypePlus as $typePlus)
                                                                        @if ($typePlus) <li class="{{ $typePlus }}">{{ $typePlus }}</li> @endif
                                                                    @endforeach
                                                                @endif
                                                            </ul>
                                                            <span class="day">{{ $comic->time_up }}</span>
                                                        </figure>
                                                        <div class="desc">
                                                            <h4 class="title">{{ $comic->title }}</h4>
                                                            @php $listWriters = getArrayTitleWriterInComic($comic->id); @endphp
                                                            <p class="writer">{{ implode(" | ",$listWriters) }}</p>
                                                            <div class="meta-chap flex item-center content-between">
                                                                <ul class="meta list-unstyled flex item-center content-start">
                                                                    @php $listTypes = getObjTitleColorTypeInComic($comic->id); $count = 0;@endphp
                                                                    @foreach ($listTypes as $item)
                                                                        @php $count ++; @endphp
                                                                        <li @if($count > 1) class="active" @endif style="color:{{ $item->color }};">{{ $item->title }}</li>
                                                                    @endforeach
                                                                </ul>
                                                                <span class="chap">{{ getNumLastChapByComicId($comic->id) }}</span>
                                                            </div>
                                                        </div>
                                                        <a href="{{ route('listChap',['slug'=>$comic->slug]) }}" class="read-more"></a>
                                                    </div>
                                                </div>
                                            @endif 
                                        @endif
                                   @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
       </section>
    </div>
@endsection