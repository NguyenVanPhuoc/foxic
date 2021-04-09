@extends('templates.master')
@section('title', $comic->showTitle().' - '.$chap->chap)
@php
    if($seo){
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

    @if(isset($bgc))
        <div id="chap-page" class="pages comic-pages" style="background-color: {{ explode('__',$bgc)[0] }}; color: {{ explode('__',$bgc)[1] }}">
    @else
        <div id="chap-page" class="pages comic-pages">
    @endif    
    	<div class="breadcrumbs"><div class="container">{!! Breadcrumbs::render('chapComic', $comic, $chap->chap);  !!}</div></div>
    	@if(isset($frm_fluid) && $frm_fluid == 'yes')
            <div class="page-content container-fluid">
        @else
            <div class="page-content container">
        @endif
            <a href="javascript:void(0);" class="btn-orange toggle-nav"><i class="fa fa-chevron-up"></i></a>
			<h2 class="comic-title"><a href="{{ route('listChap',$comic->slug).'/' }}" title="{{ $comic->showTitle() }}">{{ $comic->showTitle() }}</a></h2>
            <h3 class="comic-title">
                {{ $chap->book->showTitle() }}
            </h3>
			<h4 class="chap-title"><a href="{{ route('detailChap',['slugComic'=>$comic->slug,'slugChap'=>$chap->slug]).'/' }}" title="{{ $comic->showTitle().' - '.$chap->chap }}">{{ $chap->chap.': '.$chap->showTitle() }}</a></h4>
			<div class="chap-nav">
				@if(count($prev) >  0)
                    <a href="{{ route('detailChap',['slugComic'=>$comic->slug,'slugChap'=>$prev[0]->slug]).'/' }}" class="btn-cs btn-orange prev"><span class="glyphicon glyphicon-chevron-left"></span><span class="hidden-480">{{ _('Chương trước') }}</span></a>
                @else
                    <a href="javascript:void(0);" class="btn-cs btn btn-orange prev disabled"><span class="glyphicon glyphicon-chevron-left"></span><span class="hidden-480">{{ _('Chương trước') }}</span></a>
                @endif                                  
                <a href="javascript:void(0);" class="btn-cs btn-orange s-list"><span class="glyphicon glyphicon-list-alt"></span></a>
                <select name="select-chap1" class="form-control select-chap btn-orange">
                    @foreach( $chaps as $item )
                        <option value="{{ route('detailChap',['slugComic'=>$comic->slug,'slugChap'=>$item->slug]).'/' }}" {{ ($chap->slug == $item->slug) ? 'selected' : '' }}>{{ $item->chap }}</option>
                    @endforeach
                </select>
                @if(count($next) >  0)
                    <a href="{{ route('detailChap',['slugComic'=>$comic->slug,'slugChap'=>$next[0]->slug]).'/' }}" class="btn-cs btn-orange next"><span class="hidden-480">{{ _('Chương tiếp') }}</span><span class="glyphicon glyphicon-chevron-right"></span></a>
                @else
                    <a href="javascript:void(0);" class="btn-cs btn btn-orange next disabled"><span class="hidden-480">{{ _('Chương tiếp') }}</span><span class="glyphicon glyphicon-chevron-right"></span></a>
                @endif 
			</div>
            @php
                if(isset($frm_break) && $frm_break == 'yes') {
                    $new_ct = preg_replace('#(<\s*br[^/>]*/?\s*>\s*){2,}#is',"<br />\n",$chap->content);
                }else{
                    $new_ct = $chap->content;
                }
            @endphp
            @if(isset($lih) || isset($foz) || isset($font))
                <div class="chap-detail" style="line-height: {{ isset($lih) ? $lih : '120%' }}; font-size: {{ isset($foz) ? $foz : '22px' }}; font-family: {{ isset($font) ? $font : 'Roboto' }}; ">{!! $new_ct !!}</div>
            @else
                <div class="chap-detail">{!! $new_ct !!}</div>
            @endif                       	
			<div class="chap-nav">
                @if(count($prev) >  0)
                    <a href="{{ route('detailChap',['slugComic'=>$comic->slug,'slugChap'=>$prev[0]->slug]).'/' }}" class="btn-cs btn-orange prev"><span class="glyphicon glyphicon-chevron-left"></span><span class="hidden-480">{{ _('Chương trước') }}</span></a>
                @else
                    <a href="javascript:void(0);" class="btn-cs btn btn-orange prev disabled"><span class="glyphicon glyphicon-chevron-left"></span><span class="hidden-480">{{ _('Chương trước') }}</span></a>
                @endif                        			
				<a href="javascript:void(0);" class="btn-cs btn-orange s-list"><span class="glyphicon glyphicon-list-alt"></span></a>
                <select name="select-chap1" class="form-control select-chap btn-orange">
                    @foreach( $chaps as $item )
                        <option value="{{ route('detailChap',['slugComic'=>$comic->slug,'slugChap'=>$item->slug]).'/' }}" {{ ($chap->slug == $item->slug) ? 'selected' : '' }}>{{ $item->chap }}</option>
                    @endforeach
                </select>
                @if(count($next) >  0)
                    <a href="{{ route('detailChap',['slugComic'=>$comic->slug,'slugChap'=>$next[0]->slug]).'/' }}" class="btn-cs btn-orange next"><span class="hidden-480">{{ _('Chương tiếp') }}</span><span class="glyphicon glyphicon-chevron-right"></span></a>
                @else
                    <a href="javascript:void(0);" class="btn-cs btn btn-orange next disabled"><span class="hidden-480">{{ _('Chương tiếp') }}</span><span class="glyphicon glyphicon-chevron-right"></span></a>
                @endif 
			</div>
			<div class="text-center">
				<a href="javascript:void(0);" class="btn-cs btn-warning chap-error"><span class="glyphicon glyphicon-flag"></span>{{ _('Báo lỗi chương') }}</a>
			</div>
			<div class="text-center"><div class="notice">{{ _('Bạn có thể dùng phím mũi tên hoặc WASD để lùi/sang chương.') }}</div></div>
    	</div>
    </div>
<script type="text/javascript">
    if($('#chap-page').length > 0) {
        localStorage.setItem('@php echo $comic->id; @endphp', '@php echo $chap->id @endphp');
    }
</script>
@endsection