@extends('templates.master')
@section('title', $page->title)
	@if($seo)
		@section('description', $seo->value)
		@section('keywords', $seo->key)
	@endif
@section('content')
    <div id="favorite-page" class="pages dynamic-pages">
        @if (Auth::check())
            @include('banners/bannerVip')
        @endif
        <section class="page-content">
            <div class="container">
                <div class="sec-title flex item-center content-start">
                    <h3><img src="{{ asset('public/images/icons/ico_favorites_on.png') }}" alt="{{ $page->title }}">{{ $page->title }}</h3>
                    @if (!Auth::check())
                        <p><img src="{{ asset('public/images/icons/ico_notice.png') }}" alt="">{{ _('There are no favorited comics.') }}</p>
                    @else
                        @if ($listFavorites->isEmpty())
                            <p><img src="{{ asset('public/images/icons/ico_notice.png') }}" alt="">{{ _('There are no favorited comics.') }}</p>
                        @endif
                    @endif
                </div>
                <div class="sec-content">
                    <div class="list-comics">
                        <div class="inner row">
                            @if (Auth::check())
                                @if ($listFavorites->isNotEmpty())
                                    @foreach ($listFavorites as $comic)
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
                                                        </figure>
                                                        <div class="desc">
                                                            <h4 class="title">{{ $comic->title }}</h4>
                                                            <div class="meta-chap flex item-center content-between">
                                                                <ul class="meta list-unstyled flex item-center content-start">
                                                                    <li>{{ $comic->created_at->diffForHumans() }}</li>
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
                                                        </figure>
                                                        <div class="desc">
                                                            <h4 class="title">{{ $comic->title }}</h4>
                                                            <div class="meta-chap flex item-center content-between">
                                                                <ul class="meta list-unstyled flex item-center content-start">
                                                                    <li>{{ $comic->created_at->diffForHumans() }}</li>
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
                            @endif
                        </div>
                    </div>
                </div>
            </div>
       </section>
    </div>
@endsection