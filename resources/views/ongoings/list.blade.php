@extends('templates.master')
@section('title', $page->title)
	@if($seo)
		@section('description', $seo->value)
		@section('keywords', $seo->key)
    @endif
    @php $timeUp = (isset($_GET['time_up']) && $_GET['time_up'] != '') ? $_GET['time_up'] : '';@endphp
@section('content')
    <div id="ongoing-page" class="pages">
        @if (Auth::check())
            @include('banners/bannerVip')
        @endif
        <section class="page-content">
            <div class="container">
                <div class="sec-title flex item-center content-between">
                    <h3><img src="{{ asset('public/images/icons/ico_ongoing.png') }}" alt="{{ _('Ongoning') }}">{{ _('Ongoning') }}</h3>
                    <ul class="nav-radio list-unstyled flex item-center content-end">
                        @if ( $timeUp == '' )
                            <li @if($timeUp == '') class="active" @endif><a href="{{ route('ongoing') }}">{{ _('All') }}</a></li>
                            <li><a href="{{ route('ongoing') }}?time_up={{ strtolower(date('D')) }}">{{ _('Today') }}</a></li>
                        @else
                            <li><a href="{{ route('ongoing') }}">{{ _('All') }}</a></li>
                            <li class="active"><a href="javascript:void(0);">{{ $timeUp }}</a></li>
                        @endif
                    </ul>
                </div>
                <div class="sec-content">
                    <ul id="list-day" class="list-show list-unstyled flex item-center content-between text-center">
                        @php $dayOrWeek = config('data_config.date'); @endphp
                        @if ( $timeUp == '')
                            @foreach ($dayOrWeek as $item) @if ($item != '') <li class="@if($timeUp == $item['value'])active @endif @if($item['value'] == strtolower(date('D')))today @endif"><a href="{{ route('ongoing') }}?time_up={{ $item['value'] }}">{{ $item['title'] }}</a></li>@endif
                            @endforeach
                        @else
                            <li class="@if($timeUp == '') active @endif "><a href="{{ route('ongoing') }}">{{ _('All') }}</a></li>
                            @foreach ($dayOrWeek as $item) <li class="@if($timeUp == $item['value'])active @endif @if($item['value'] == strtolower(date('D')))today @endif"><a href="{{ route('ongoing') }}?time_up={{ $item['value'] }}">{{ $item['title'] }}</a></li>@endforeach
                        @endif
                    </ul>
                    <div class="list-comics">
                        <div class="inner row">
                            @if ($comicOngings->isNotEmpty())
                                @foreach ($comicOngings as $comic)
                                    @if ($status == 'off')
                                        @php 
                                            $typePlusArr = explode(',',$comic->type_plus);
                                            $flag = false;
                                            foreach ($typePlusArr as $type_plus) {
                                                if ($type_plus == '18+') {
                                                    $flag = true;
                                                }
                                            }
                                        @endphp
                                        @if ($flag == true)
                                            <div class="item col-md-2">
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
                                    @else
                                        @php 
                                            $typePlusArr = explode(',',$comic->type_plus);
                                            $flag = false;
                                            foreach ($typePlusArr as $type_plus) {
                                                if ($type_plus == '18+') {
                                                    $flag = true;
                                                }
                                            }
                                        @endphp
                                        @if ($flag == false)
                                            <div class="item col-md-2">
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
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
       </section>
    </div>
@endsection