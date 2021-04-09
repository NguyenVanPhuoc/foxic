@extends('templates.master')
@section('title', $comic->showTitle())
@php
    if(isset($seo)){
        $seo_key = $seo->key;
        $seo_value = $seo->value;
    }else{
        $seo_key = '';
        $seo_value = '';
    }
     $user = getCurrentUser();
@endphp
@section('keywords', $seo_key)
@section('description',$seo_value)
@section('content')
    <div id="comic-page" class="pages detail-comic">
        <div class="breadcrumbs"><div class="container">{!! Breadcrumbs::render('catComic', $comic->showTitle());  !!}</div></div>
        <section class="page-content">
            <div class="container"> 
             @if($comic->mature == 1)
                    <p class="notyfile">{{ __('Nội dung trưởng thành 18+ , chúng tôi sẽ không chịu trách nhiệm pháp luật nếu bạn đọc truyện này.')}}</p>
                @endif 
                @include('notices.index')           
                <div class="row">                    
                    <div id="content" class="col-md-8" data-url = "{{ route('saveStarRate') }}">
                        <div class="sec-title"><h2>{{ _('Thông tin truyện') }}</h2></div>
                        <div class="summary">
                            <h3 class="comic-title">{{ $comic->showTitle() }}</h3>
                            <div class="row">
                                <div class="col-sm-4 info">
                                    <div class="wrap-book"><div class="book">{!! imageAuto($comic->image,$comic->showTitle()) !!}</div></div>
                                </div>
                                <div class="col-sm-8 desc">                                
                                    <div class="wrap-rate">
                                        <div class="star-rating">
                                            {!!csrf_field()!!}
                                            <div class="rate" data-rate = "{{ $comic->rating }}" data-readonly = "{{ $readonly }}" data-id="{{ $comic->id }}"></div> 
                                            <div id="hint"></div>                                   
                                        </div>
                                        @if($comic->votes != 0)
                                            <div class="small">{{ _('Đánh giá: ') }}<strong>{{ round($comic->rating,1) }}</strong> {{ '/5 từ ' }}<strong>{{ $comic->votes.' lượt.' }}</strong></div>
                                        @else
                                            <div class="small">{{ _('Chưa có đánh giá!') }}</div>
                                        @endif
                                        <span class="view_all"><b>{{ _('Lượt xem: ') }}</b>{{ isset($views->view_all) ? $views->view_all : '0'}}</span>    
                                    </div>
                                    <ul class="meta">
                                         @if(getObjSlugTitleWriterInComic($comic->id)!=null)
                                        <li><strong>{{ _('Tác giả: ') }}</strong>{!! getObjSlugTitleWriterInComic($comic->id) !!}</li>
                                        @endif
                                        @if(getObjSlugTitleArtistInComic($comic->id)!=null)
                                        <li><strong>{{ _('Họa sĩ: ') }}</strong>{!! getObjSlugTitleArtistInComic($comic->id) !!}</li>
                                        @endif
                                        <li><strong>{{ _('Thể loại: ') }}</strong>{!! getObjSlugTitleTypeInComic($comic->id) !!}</li>
                                        @if (isset($comic->source))
                                            <li><strong>{{ _('Nguồn: ') }}</strong>{{ $comic->source }}</li>
                                        @endif
                                        <li><strong>{{ _('Trạng thái: ') }}</strong>{{ $comic->au_status }}</li>
                                    </ul>
                                    <div class="flex">
                                        <div class="read-next" data="{{ $comic->id}}" action="{{ route('localStorage') }}">
                                            {!!csrf_field()!!}
                                        </div>
                                        <div class="donate-vnp" data-link="{{ route('donateAuthor') }}">
                                            {{ csrf_field() }}
                                            <span class="btn btn-donate"><i class="fas fa-donate"></i></span>
                                            <div class="popover bs-popover-bottom">
                                                <div class="close"><i class="iconfont icon-close"></i></div>
                                                <div class="popover-body">
                                                    <div class="position-relative form-group">
                                                        <label for="idNumStones" class="">Số Point Muốn Ủng Hộ</label>
                                                        <input id="idNumStones" placeholder="Nhập số nguyên lớn hơn 0..." type="number" class="form-control" value="10">
                                                    </div>
                                                    <button type="button" class="btn btn-success btn-donate-nvp btn-block" comic-id={{$comic->id}}><span> Ủng Hộ Ngay</span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="short-desc">{!! $comic->desc !!}</div>
                                    <a href="#" class="view_more">{{ _('Xem thêm: ') }}</a>
                                </div>
                            </div>
                        </div>
                        <section class="bookchap">
                            <div class="list-book">
                                @if($book_chap->books->isNotEmpty())
                                    @foreach($book_chap->books as $item)
                                        <div class="item">
                                            <h4 class="title-book">{{ $item->showTitle()}}</h4>
                                            <div class="row list-chap">
                                                <div class="col-md-2 thumb-img">
                                                    {!! imageAuto($item->image,$item->showTitle()) !!}
                                                </div>
                                                 <div class="col-md-10 book-right">
                                                    <ul class="list-chapters">
                                                    @if($item->chaps->isNotEmpty())
                                                        @foreach($item->chaps as $chap)
                                                            <li><span>{{ $chap->chap}}: {{ $chap->showTitle()}} @desktop<small>({{ date_format($chap->created_at, 'd/m/Y')}})</small>@enddesktop</span>
                                                                <p>
                                                                @if($chap->rental == 0 && $chap->point == 0)
                                                                    <a class="free" href="{{ route('detailChap',['slugComic'=>$comic->slug,'slugChap'=>$chap->slug]) }}"></a>
                                                                    <span class="green">{{ __('Miễn phí')}}</span>
                                                                    @handheld<p class="update-date">({{ date_format($chap->created_at, 'd/m/Y')}})</p>@endhandheld
                                                                @else
                                                                    @if(Auth::check()) 
                                                                        @php
                                                                            $user = Auth::user();
                                                                            $check = checkRentChaps($chap->id, $user->id);
                                                                            $buy = checkBuyChaps($chap->id, $user->id);
                                                                        @endphp
                                                                        @if($buy == 1) 
                                                                            <a class="free" href="{{ route('detailChap',['slugComic'=>$comic->slug,'slugChap'=>$chap->slug]) }}"></a>
                                                                            <span class="green">{{ __('Đã mua')}}</span>
                                                                            @handheld<p class="update-date">({{ date_format($chap->created_at, 'd/m/Y')}})</p>@endhandheld
                                                                        @else
                                                                            @if($check==1)
                                                                                <a class="link-chap" href="{{ route('detailChap',['slugComic'=>$comic->slug,'slugChap'=>$chap->slug]) }}"></a>
                                                                                <span class="green">{{ __('Đã thuê')}}</span>
                                                                                @handheld<p class="update-date">({{ date_format($chap->created_at, 'd/m/Y')}})</p>@endhandheld
                                                                                @if($chap->point > 0)
                                                                                    @if($user->point < $chap->point)
                                                                                        <span class="image-point modal-point"><span class="number">{{ $chap->point}}</span><img src="{{ asset('public/images/icons/image-point .png') }}"></span>
                                                                                    @else
                                                                                        <span class="image-point buy-chaps" data-id="{{ $chap->id }}" point="{{ $chap->point }}"><span class="number">{{ $chap->point}}</span><img src="{{ asset('public/images/icons/image-point .png') }}"></span>
                                                                                    @endif
                                                                                @endif  
                                                                            @else
                                                                                @if($user->rental < $chap->rental)
                                                                                    <span class="thumb chaps-number"><span class="number">{{ $chap->rental}}</span><img src="{{ asset('public/images/icons/img-rent-ticket.png') }}"></span>
                                                                                @else
                                                                                    <span class="thumb rent-chaps" data-id="{{ $chap->id }}" rental="{{ $chap->rental }}"><span class="number">{{ $chap->rental}}</span><img src="{{ asset('public/images/icons/img-rent-ticket.png') }}"></span>
                                                                                @endif
                                                                                @if($chap->point > 0)
                                                                                    @if($user->point < $chap->point)
                                                                                        <span class="image-point modal-point"><span class="number">{{ $chap->point}}</span><img src="{{ asset('public/images/icons/image-point .png') }}"></span>
                                                                                    @else
                                                                                        <span class="image-point buy-chaps" data-id="{{ $chap->id }}" point="{{ $chap->point }}"><span class="number">{{ $chap->point}}</span><img src="{{ asset('public/images/icons/image-point .png') }}"></span>
                                                                                    @endif   
                                                                                @endif   
                                                                            @endif
                                                                        @endif
                                                                    @else
                                                                        <a href="{{ route('storeLoginCustomer',['link'=>url()->current()]) }}"><span class="thumb"><span class="number">{{ $chap->rental}}</span><img src="{{ asset('public/images/icons/img-rent-ticket.png') }}"></span></a>
                                                                        @if($chap->point > 0)
                                                                            <a href="{{ route('storeLoginCustomer',['link'=>url()->current()]) }}"><span class="image-point"><span class="number">{{ $chap->point}}</span><img src="{{ asset('public/images/icons/image-point .png') }}"></span></a>
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                                </p>
                                                            </li>
                                                        @endforeach
                                                    @else
                                                        <h5>{{ _('Truyện đang trong quá trình viết chương đầu tiên!') }}</h5>
                                                    @endif
                                                    </ul>
                                                    @if($item->chaps_count >= 6)
                                                    <div class="see_more"><span>Xem tiếp ({{$item->chaps_count}})</span></div>
                                                    @endif
                                                </div>
                                            </div>     
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </section>
                        <div class="comments">
                            @include('comics.comments')
                        </div>
                    </div>
                    <div id="sidebar" class="col-md-4">
                        <aside id="sb-writer" class="sb-comic">
                            <div class="sb-title">
                                <h3>{{ _('Truyện cùng tác giả') }}</h3>
                            </div>
                            <ul class="list-item">
                                @if ($sames->isNotEmpty())
                                    @foreach($sames as $item)
                                        <li><span class="glyphicon glyphicon-chevron-right"></span><a href="{{ route('listChap',$item->slug).'/' }}" title="{{ $item->title }}">{{ $item->title }}</a></li>
                                    @endforeach
                                @endif
                            </ul>                            
                        </aside>
                        {!! getListHotComic() !!}
                    </div>                    
                </div>
            </div>
       </section>
    </div>
    @if(isset($_COOKIE['themeStyle']) && $_COOKIE['themeStyle'] == "dark-theme"):
        <style type="text/css">
            .fb-comments {
                filter: invert(1) hue-rotate(165deg) saturate(70%);
            }
        </style>
    @endif
@if(Auth::check())
    @include('modals.edit-comment')
    @include('modals.modal-delete-comment')
@endif
<div id="rentChaps" class="modal fade" role="dialog" data-link="{{ route('rentChap') }}">
{{ csrf_field() }}
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <input type="hidden" name="chap_id" value>
        <input type="hidden" name="rental" value>
        <h4>{{ __('Bạn có đồng ý thuê chương này không !!!')}}</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success">Đồng ý</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy</button>
      </div>
    </div>
  </div>
</div>
<div id="chapsNumber" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <h4>{{ __('Số phiếu trong tài khoản bạn không đủ để thuê chương này ! Vui lòng đổi thêm phiếu ')}}</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy</button>
      </div>
    </div>
  </div>
</div>
<div id="buyChaps" class="modal fade" role="dialog" data-link="{{ route('buyChap') }}">
{{ csrf_field() }}
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <input type="hidden" name="chap_id" value>
        <input type="hidden" name="point" value>
        <h4>{{ __('Bạn có đồng ý mua chương này không !!!')}}</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success">Đồng ý</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy</button>
      </div>
    </div>
  </div>
</div>
<div id="numberPoint" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <h4>{{ __('Số Point trong tài khoản bạn không đủ để mua chương này ! Vui lòng mua thêm Point ')}}</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy</button>
      </div>
    </div>
  </div>
</div>
@endsection