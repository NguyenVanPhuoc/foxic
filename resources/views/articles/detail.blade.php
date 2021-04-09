@extends('templates.master')
@section('title', $article->title)
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
    <div id="article" class="pages detail-comic">
       <section class="page-content">
            <div class="container">             
                <div class="row"> 
                    <div class="content-article col-md-8">
                       <div class="sec-title"><h2>{{ _('Tin tức - Review') }}</h2></div>
                        <div class="summary">
                            <h3 class="comic-title">{{ $article->title }}</h3>
                            <div class="row">
                                <div class="col-sm-4 info">
                                    <div class="wrap-book"><div class="book">{!! imageAuto($article->image,$article->title) !!}</div></div>
                                </div>
                                <div class="col-sm-8 desc">
                                        @php 
                                            $cats = $article->cate_id; 
                                            $cate ='';
                                            foreach($cats as $keys => $cat_id){
                                                $cat = get_categories_article($cat_id); 
                                                $cate .= '<span>'.$cat->title.($keys != (count($cats))-1 ? ', ' : '').'</span>';
                                            }
                                        @endphp
                                    <div class="cate">
                                        <h4>Danh mục: </h4> {!! $cate !!}
                                    </div>                                
                                </div>
                            </div>
                            <div class="short-desc">{!! $article->content !!}</div>
                            <a href="#" class="view_more">{{ _('Xem thêm: ') }}</a>
                            <div class="interested">
                                <div class="sec-title"><h2>{{ _('Bài viết liên quan') }}</h2></div>
                                @desktop
                                    <div class="list-cat row">
                                        @foreach($list_article as $item)
                                            <div class="item col-md-4">
                                                <a href="{{ route('detailArticle',$item->slug).'/' }}" title="{{ $item->title }}">
                                                    {!! image($item->image,'229','270',$item->title) !!} 
                                                    <h4 class="title-cat">{{ $item->title }}</h4>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @elsedesktop
                                <div class="news_chaps">
                                    <ul class="list-item">
                                        @foreach($list_article as $item)
                                            <li>
                                                <i class="fa fa-certificate"></i>
                                                <a href="{{ route('detailArticle',$item->slug).'/' }}" title="{{ $item->title }}">{{ $item->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @enddesktop
                            </div>
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
@endsection