@extends('templates.master')
@if($typeComic == 'comicSearch')
    @section('title',$comic)
@else
    @section('title', ($typeComic != 'comicWriter') ? $comic->showTitle() : 'Tác giả '.$comic->showTitle())
@endif
@php
    if(isset($seo)){
        $seo_key = $seo->key;
        $seo_value = $seo->value;
    }else{
        $seo_key = '';
        $seo_value = '';
    }
@endphp
@section('keywords', $seo_key)
@section('description',$seo_value)
@section('content')
    <div id="comic-page" class="pages taxo-page">        
        <div class="breadcrumbs">
            <div class="container">
                @if($typeComic == 'comicSearch')
                    {!! Breadcrumbs::render('catComic', $comic);  !!}
                @else
                    {!! Breadcrumbs::render('catComic', $comic->showTitle());  !!}
                @endif                
            </div>
        </div>
        <section class="page-content">
            <div class="container">                
                <div class="row">
                    @if($typeComic == 'comicSearch' && strlen($keyword)<3)
                        <div id="content" class="col-md-8">
                            <div class="page-title">
                                <h2>{{ ($comic) ? $comic : '' }}</h2>                                
                            </div>
                            <p>{{ __('Từ khóa quá ngắn, vui lòng tìm với từ khóa dài hơn 3 ký tự.') }}</p>                            
                        </div>
                    @else                
                        <div id="content" class="col-md-8">
                            <div class="page-title">
                                @if($typeComic == 'comicSearch')
                                    <h2>{{ ($comic) ? $comic : '' }}</h2>                                    
                                @else
                                    <h2>{{ ($typeComic != 'comicWriter') ? $comic->showTitle() : 'Tác giả '.$comic->showTitle() }}</h2>
                                @endif                             
                                @if($typeComic == 'comicCat')
                                    @if($full == 'catFull')
                                    @elseif ($full == 'full')
                                        <a href="{{ route('catChap',$comic->slug).'/' }}" class="right-item">{{ $comic->showTitle() }}</a>
                                    @else
                                        <a href="{{ route('catChapFull',$comic->slug).'/' }}" class="right-item">{{ $comic->showTitle() . ' hoàn thành (FULL)' }}</a>
                                    @endif
                                @elseif($typeComic == 'comicType')
                                    @if ($full == 'full')
                                        <a href="{{ route('typeChap',$comic->slug).'/' }}" class="right-item">{{ $comic->showTitle() }}</a>
                                    @else
                                        <a href="{{ route('typeChapFull',$comic->slug).'/' }}" class="right-item">{{ $comic->showTitle() . ' hoàn thành (FULL)' }}</a>
                                    @endif
                                @endif    
                            </div> 
                            <div class="list-stores">
                                @if ($comics->isNotEmpty())
                                    @foreach($comics as $item)
                                        @php 
                                            $authors = getArrayTitleWriterInComic($item->id); 
                                        @endphp
                                        <div class="item row flex-list">
                                            <div class="col-xs-3 feature">{!! image($item->image,180, 90 ,$item->showTitle()) !!}</div>
                                            <div class="col-xs-7 infor">                                                
                                                <h3 class="store-title"><a href="{{ route('listChap',$item->slug).'/' }}"><span class="glyphicon glyphicon-book"></span> {{ $item->title }}</a></h3>
                                                @if (checkComicHot($item->id)) <span class="label-title label-hot"></span> @endif
                                                @if (checkComicNew($item->id)) <span class="label-title label-new"></span> @endif
                                                @if (checkComicFull($item->id)) <span class="label-title label-full"></span> @endif
                                                {{-- @if ($item->end == 1) <span class="label-title label-full"></span> @endif --}}
                                                @if($authors != null)
                                                    <p class="author"><span class="glyphicon glyphicon-pencil"></span>
                                                        @foreach($authors as $key=>$author)
                                                            @if($key < count($authors)-1)
                                                                {{ $author.', ' }}
                                                            @else 
                                                                {{ $author }}
                                                            @endif    
                                                        @endforeach                                                
                                                    </p>
                                                @endif                                            
                                            </div>
                                            <div class="col-xs-2 chapter">
                                                @php $chap = getLatestChapByComicId($item->id);@endphp
                                                @if($chap)
                                                    <a href="{{ route('detailChap',['slugComic'=>$item->slug,'slugChap'=>$chap->slug]).'/' }}" title="{{ $chap->showTitle().' - '.$chap->chap }}"><span>{{ $chap->chap }}</span><span class="short-chap">{{ $chap->short_chap }}</span></a>
                                                @else {{ __('Chưa có') }}
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach 
                                @else
                                    <h4 class="notify">{{ __('Mục này chưa có bài viết nào!') }}</h4>
                                @endif
                            </div>
                            <div class="text-center">
                                @if( isset($order_by) && $order_by != '')
                                    {!! $comics->appends(['order_by'=>$order_by])->links() !!}
                                @else
                                    {{ $comics->links() }}
                                @endif
                            </div>             
                        </div>
                    @endif    
                    <div id="sidebar" class="col-md-4">
                        @if($typeComic == 'comicSearch')
                           <aside class="sb-comic" id="desc-cat"><p>{{ 'Danh sách truyện có liên quan tới từ khoá "'.$keyword.'"' }}</p></aside>
                        @elseif($typeComic == 'comicWriter')
                           <aside class="sb-comic" id="desc-cat"><p>{{ 'Danh sách truyện của tác giả '.$comic->showTitle() }}</p></aside>
                        @elseif($comic->desc != '')
                            <aside class="sb-comic" id="desc-cat"><p>{!! $comic->desc !!}</p></aside>
                        @endif
                        <aside id="sb-type" class="sb-comic">
                            <div class="sb-title">
                                <h3>{{ __('Thể loại truyện') }}</h3>
                            </div>
                            <div class="list-type row">
                                @php $typeComics = getListTypeComic();@endphp
                                @foreach ($typeComics as $type)
                                    <div class="item col-md-6">
                                        <a href="{{ route('typeChap',['slug'=>$type->slug]).'/' }}">{{ $type->showTitle() }}</a>
                                    </div>
                                @endforeach   
                            </div>
                        </aside>
                        @if($typeComic == 'comicType')
                            {!! getListHotComic($comic->id) !!}
                        @else
                            {!! getListHotComic() !!}
                        @endif    
                    </div>                    
                </div>
            </div>
       </section>
    </div>
    {{-- @include('comics.like_op') --}}
@endsection