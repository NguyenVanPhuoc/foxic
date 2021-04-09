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
    <div id="comic-page" class="pages taxo-page">        
        
        <section class="page-content">
            <div class="container">                
                <div class="row">
                                  
                        <div id="content" class="col-md-8">
                            <div class="page-title">
                                <h2>Truyện Mới Cập Nhật</h2>                                                          
                            </div>
                            <div class="list-stores">
                                @if ($comics->isNotEmpty())
                                    @foreach($comics as $item)
                                        @php $authors = getArrayTitleWriterInComic($item->id) @endphp
                                        <div class="item row flex-list">
                                            <div class="col-xs-3 feature">{!! image($item->image,180, 90 ,$item->showTitle()) !!}</div>
                                            <div class="col-xs-7 infor">                                                
                                                <h3 class="store-title"><a href="{{ route('listChap',$item->slug).'/' }}"><span class="glyphicon glyphicon-book"></span> {{ $item->showTitle() }}</a></h3>
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
                    <div id="sidebar" class="col-md-4">
                        {!! getListHotComic() !!}  
                    </div>                    
                </div>
            </div>
       </section>
    </div>
    {{-- @include('comics.like_op') --}}
@endsection