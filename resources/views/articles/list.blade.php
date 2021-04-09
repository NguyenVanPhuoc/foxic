@extends('templates.master')
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
    <div id="comic-page" class="pages taxo-page temp-review">        
        <div class="breadcrumbs">
            <div class="container">
                @if($typeComic == 'comicSearch')
                    {!! Breadcrumbs::render('catArticle', $cate);  !!}
                @else
                    {!! Breadcrumbs::render('catArticle', $cate->title);  !!}
                @endif                
            </div>
        </div>
        <section class="page-content">
            <div class="container">                
                <div class="row">              
                        <div id="content" class="col-md-8">
                            <div class="list-stores">
                                @if ($list_article->isNotEmpty())
                                    @foreach($list_article as $item)
                                        <div class="item row flex-list">
                                            <div class="col-md-3 col-xs-3 feature">{!! image($item->image,180, 90 ,$item->title) !!}</div>
                                            <div class="col-md-7 col-xs-9 infor">                                                
                                                <h3 class="store-title"><a href="{{ route('detailArticle',$item->slug).'/' }}"><span class="glyphicon glyphicon-book"></span> {{ $item->title }}</a></h3>  
                                                <div class="desc">
                                                    {!! $item->desc !!}
                                                </div>                            
                                            </div>
                                            
                                        </div>
                                    @endforeach 
                                @else
                                    <h4 class="notify">{{ __('Mục này chưa có bài viết nào!') }}</h4>
                                @endif
                            </div>
                            <div class="text-center">
                               {{ $list_article->links() }}
                            </div>   
                        </div>   
                    <div id="sidebar" class="col-md-4">
                        <aside id="sb-type" class="sb-comic">
                            <div class="sb-title">
                                <h3>{{ __('Thể loại truyện') }}</h3>
                            </div>
                            <div class="list-type row">
                                @php $typeComics = getListTypeComic();@endphp
                                @foreach ($typeComics as $type)
                                    <div class="item col-md-6">
                                        <a href="{{ route('typeChap',['slug'=>$type->slug]).'/' }}">{{ $type->title }}</a>
                                    </div>
                                @endforeach   
                            </div>
                        </aside>
                        {!! getListHotComic() !!}  
                    </div>                    
                </div>
            </div>
       </section>
    </div>
    {{-- @include('comics.like_op') --}}
@endsection