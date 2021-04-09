<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="nue2yPo8zEhxFTqyvWcherHQKvZKV0hwAS04gkFBN2g">
        <title>@yield('title')</title>
        <meta http-equiv="Content-Language" content="en">
        <meta name="description" content="@yield('description')">
        <meta name="keywords" content="@yield('keywords')">
        <link rel="canonical" href="{{ url()->current().'/'}}"> 
        <link rel="shortcut icon" href="{{ favicon() }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/normalize.css') }}" >
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/bootstrap.min.css') }}" >
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/owl.theme.default.min.css') }}">
        <!--flatpickr-->
        {{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css"> --}}
        <!--flatpickr-->
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/dropzone.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/airbnb.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/jquery-ui.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/pnotify.custom.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/scrollbar.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/select2.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/all.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/checkbox_radio.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/style.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/main.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/plus.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/plus1.css') }}">
        <script type="text/javascript" src="{{ asset('public/js/jquery.min.js') }}"></script>
        @handheld <link rel="stylesheet" href="{{ asset('public/css/responsive.css') }}">@endhandheld
    </head>
    <body class="<?php if(isset($_COOKIE['themeStyle'])) echo $_COOKIE['themeStyle']; ?>">
        <div id="fb-root"></div>
        <div id="wrapper">
            @php 
                $catComics = getListCatComic(); 
                $typeComics = getListTypeComic();
            @endphp
            <header>
                <div class="top" data-link="{{ route('musterUser') }}">
                    @desktop
                    <div class="container flex item-center">
                        <div class="header-lf clearfix flex item-center content-start">
                        <figure id="logo"><a href="{{ route('home').'/' }}">{!! getLogo() !!}</a></figure>
                            <ul class="menu-left list-unstyled flex item-center content-start">
                                    <li class="dropdown  {{ \Route::current()->getName() == 'home' ? 'open' : '' }}">
                                        <a href="{{ route('home').'/' }}">{{ _(' Trang chủ ') }}</a>
                                    </li>
                                    <li class="dropdown">
                                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><i class="fas fa-list"></i>{{ _(' Loại truyện ') }}<i class="fas fa-caret-down"></i></a>
                                        <ul class="dropdown-menu" role="menu">
                                            @foreach ($catComics as $cat)
                                                <li><a href="{{ route('catChap',['slug'=>$cat->slug]).'/' }}" title="{{ $cat->title }}">{{ $cat->title }}</a></li>
                                            @endforeach
                                         
                                        </ul>
                                    </li>
                                    <li class="dropdown">
                                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><i class="fas fa-list"></i>{{ _(' Thể loại ') }}<i class="fas fa-caret-down"></i></a>
                                        <div class="dropdown-menu multi-column" role="menu">
                                            <div class="row">
                                                <div class="item col-md-4">
                                                    <ul class="list-unstyled wrap">
                                                        @php $count = 0; @endphp
                                                        @foreach ($typeComics as $type) 
                                                            @php $count++; @endphp
                                                            @if ($count <= 13)
                                                                <li><a href="{{ route('typeChap',['slug'=>$type->slug]).'/' }}" title="{{ $type->title }}">{{ $type->title }}</a></li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="item col-md-4">
                                                    <ul class="list-unstyled wrap">
                                                    @php $count = 0; @endphp
                                                    @foreach ($typeComics as $type) 
                                                        @php $count++; @endphp
                                                        @if ($count > 13 && $count <=26)
                                                            <li><a href="{{ route('typeChap',['slug'=>$type->slug]).'/' }}" title="{{ $type->title }}">{{ $type->title }}</a></li>
                                                        @endif
                                                    @endforeach
                                                    </ul>
                                                </div>
                                                <div class="item col-md-4">
                                                    <ul class="list-unstyled wrap">
                                                    @php $count = 0; @endphp
                                                    @foreach ($typeComics as $type) 
                                                        @php $count++; @endphp
                                                        @if ($count > 26 && $count <=38)
                                                            <li><a href="{{ route('typeChap',['slug'=>$type->slug]).'/' }}" title="{{ $type->title }}">{{ $type->title }}</a></li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown">
                                        <a href="{{ route('contact') }}">{{ _(' Liên hệ ') }}</a>
                                    </li>
                                    
                                </ul>
                        </div>
                        <div class="header-rf clearfix flex item-center content-end">
                            <div class="search-box">
                                {!!csrf_field()!!}
                                <form id="form-seach" action="{{ route('searchComic') }}" method="GET" class="dev-form">
                                    <div id="frm-search" class="input-group">
                                        <input type="text" name="keyword" class="form-control" placeholder="Tìm tên truyện, tên tác giả." required>
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-search"><i class="far fa-search"></i></button>
                                        </div>
                                    </div>
                                    <div id="search-res" data-href="{{ route('searchAjaxComic') }}">
                                        <div class="search-load"><img src="{{ asset('public/images/loading_red.gif') }}" alt="loading..."></div>
                                        <div class="results"></div>
                                    </div>
                                </form>
                            </div>
                            <div class="muster" >
                                {!!csrf_field()!!}
                                @if(Auth::check()) 
                                   <a href="#" class="btn btn-muster btn-dd">{{ __('Điểm danh')}}</a>
                                @else
                                    <a href="{{ route('storeLoginCustomer') }}"  class="btn btn-dd">{{ __('Điểm danh')}}</a>
                                @endif
                            </div>
                            <div class="bell">
                                <span class="toggle-bell"><i class="fas fa-bell"></i></span>
                                @if(Auth::check())
                                    <?php $user = Auth::User(); ?>
                                    @if(count($user->unreadNotifications)>0)
                                    <span class="number-noti">{{count($user->unreadNotifications)}}</span>
                                    @endif
                                    <ul class="dropdown-bell">
                                        @if(count($user->unreadNotifications)>0)
                                            @foreach ($user->unreadNotifications as $key => $notification)
                                                @php 
                                                    if($key>=8)
                                                        break;
                                                    $notify = $notification->data;
                                                @endphp
                                                @foreach($notify as $item)
                                                @php
                                                    $notice = getNoticeById($item);
                                                @endphp
                                                    <li class="{{$key}}">
                                                        <a href="{{ route('detailNotice',['slug'=>$notice->slug]) }}">{{ $notice->title }}</a>
                                                        <span class="datetime">{{timeElapsedString($notification->created_at)}}</span>
                                                    </li>
                                                @endforeach
                                            @endforeach
                                            @if(count($user->unreadNotifications) > 8)
                                            <a href="{{ route('indexNotice') }}" class="more"><span>{{ __('Xem thêm')}}</span></a>
                                            @endif
                                        @else
                                        <li>
                                            <span class="noduble">{{ __('Không có thông báo nào! ')}}</span>
                                        </li>
                                        @endif
                                    </ul>
                                @endif
                            </div>
                            <div class="dropdown-avatar">
                                <div class="avatar">
                                    @if(Auth::check()) 
                                    @php 
                                        $user = getCurrentUser();
                                    @endphp
                                    <div class="img-vartar">
                                        @if($user->image)
                                            {!! image($user->image, 45, 45, $user->name) !!}<span class="name">{{ $user->name }}</span>
                                        @else
                                            <span>{{ $user->name }}</span>
                                        @endif
                                    </div>
                                    @else
                                        <a href="{{ route('storeLoginCustomer') }}" class="btn-muster"><span class="login">Đăng Nhập</span></a>
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    @endif
                                </div>
                                <div class="dropdown-profile">
                                    <ul class="scrollbar-inner dropdown-menu">
                                        <li class="btn-login text-left">
                                        @if(Auth::check()) 
                                            @php 
                                                $user = getCurrentUser();
                                            @endphp
                                            <div class="item img-vartar">
                                                @if($user->image)
                                                    <a href="{{ route('editProfile') }}">{!! image($user->image, 40, 40, $user->name) !!}<span class="name">{{ $user->name }}</span></a>
                                                @else
                                                    <a href="{{ route('editProfile') }}"><img src="{{ asset('public/images/avatar.png') }}" width="50" height="50" alt="avatar">
                                                    <span>{{ $user->name }}</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </li>
                                        <li>
                                            <ul>
                                                <li>
                                                    <a href="#" class="item icon profile-balance-coin">
                                                        <span class="box-icon">
                                                            <img src="{{ asset('public/images/icons/copyright.png') }}" alt="Coin">
                                                        </span>
                                                        <span class="coin">Xu</span>
                                                        <span class="number font-bold coin-balance">{{ $user->coin }}</span>
                                                        
                                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('addCoin') }}" class="item icon profile-balance-rc">
                                                        <span class="box-icon">
                                                             <img src="{{ asset('public/images/icons/parking.png') }}" alt="Point">
                                                        </span>
                                                        <span class="coin">Point</span>
                                                        @if($user->point!=null)
                                                            <span class="number font-bold rc-balance">{!! $user->point !!}</span>
                                                        @else
                                                            <span><small class="no-rc-balance">(Hiện tại bạn không có Point nào)</small></span>
                                                        @endif
                                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                            <ul>
                                                <li>
                                                    <a href="{{ route('changeVotes') }}" class="item icon votes">
                                                        <span class="box-icon">
                                                             <img src="{{ asset('public/images/icons/img-rent-ticket.png') }}" alt="rent">
                                                        </span>
                                                        <span class="text">Đổi phiếu</span>
                                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                    </a>
                                                </li>
                                   
                                                <li>
                                                    <a href="{{ route('historyChap') }}" class="item icon">
                                                        <span class="box-icon">
                                                             <img src="{{ asset('public/images/icons/book.png') }}" alt="book">
                                                        </span>
                                                        <span class="text">Tủ sách</span>
                                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('indexNotice') }}" class="item icon">
                                                        <span class="box-icon">
                                                             <img src="{{ asset('public/images/icons/bell.png') }}" alt="book">
                                                        </span>
                                                        <span class="text">Thông báo</span>
                                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                    </a>
                                                </li>
                                                @can('comics.read')
                                                <li>
                                                    <a href="{{ route('comicsAdmin') }}" class="item icon">
                                                        <span class="box-icon">
                                                             <i class="fal fa-book-open"></i>
                                                        </span>
                                                        <span class="text">Đăng truyện</span>
                                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                    </a>
                                                </li>
                                                @endcan
                                            </ul>
                                            <ul class="block-icon-logout">
                                                <li>
                                                    <a href="{{ route('logout') }}" class="item icon hide-arrow btn-logout">
                                                        <span class="box-icon">
                                                            <i class="fa fa-sign-out"></i>
                                                        </span>
                                                        <span class="text text-left">Đăng xuất</span>
                                                    </a>
                                                </li>
                                            </ul>  
                                        @endif    
                                    </ul>
                                </div>
                            </div>
                        </div>  
                    </div>
                    @elsedesktop
                    <div class="container">
                        <div class="menu-foxic">
                            <div class="nav-bar clearfix">
                               <figure id="logo"><a href="{{ route('home') }}">{!! getLogo() !!}</a></figure>
                            </div>
                            <div class="search-box">
                                {!!csrf_field()!!}
                                <form id="form-seach" action="{{ route('searchComic') }}" method="GET" class="dev-form">
                                    <div id="frm-search" class="input-group">
                                        <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm..." required>
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-search"><i class="far fa-search"></i></button>
                                        </div>
                                    </div>
                                    <div id="search-res" data-href="{{ route('searchAjaxComic') }}">
                                        <div class="search-load"><img src="{{ asset('public/images/loading_red.gif') }}" alt="loading..."></div>
                                        <div class="results"></div>
                                    </div>
                                </form>
                            </div>
                            <div class="icon-bar"> 
                                <button type="button" class="btn-cs btn-icon-menu"><i class="fas fa-bars"></i></button> 
                            </div>
                            
                        </div>
                        <div class="menu-mobi" id="menu-mobile">
                            <div class="top-mobi">
                              <h1 class="logo-mobi"><a href="{{ route('home') }}">{!! getLogo() !!}</a></h1>
                              <span class="close-mobi"><i class="fa fa-times" aria-hidden="true"></i></span>
                            <div class="muster" >
                                {!!csrf_field()!!}
                                @if(Auth::check()) 
                                   <a href="#" class="btn btn-muster btn-dd">{{ __('Điểm danh')}}</a>
                                @else
                                    <a href="{{ route('storeLoginCustomer') }}"  class="btn btn-dd">{{ __('Điểm danh')}}</a>
                                @endif
                            </div>
                            </div>
                            <ul class="menu-left" id="main-menu">
                                <li>
                                    <a href="javascript:void(0);"><i class="fas fa-list"></i>{{ __(' Loại truyện') }}<i class="fas fa-caret-right"></i></a>
                                    <ul class="sub-menu" role="menu">
                                        @foreach ($catComics as $cat)
                                            <li><a href="{{ route('catChap',['slug'=>$cat->slug]).'/' }}" title="{{ $cat->title }}">{{ $cat->title }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:void(0);"><i class="fas fa-list"></i>{{ __(' Thể loại') }}<i class="fas fa-caret-right"></i></a>
                                    <ul class="sub-menu" role="menu">
                                        @foreach ($typeComics as $type)
                                           <li><a href="{{ route('typeChap',['slug'=>$type->slug]).'/' }}" title="{{ $type->title }}">{{ $type->title }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                                @if(Auth::check()) 
                                    @php 
                                        $user = getCurrentUser();
                                    @endphp
                                    <ul class="menu-user">
                                        <li>
                                            <a href="{{ route('addCoin') }}" class="item icon profile-balance-coin">
                                                <span class="coin">Xu</span>
                                                <span class="number font-bold coin-balance">{{ $user->coin }}</span>
                                                <i class="fas fa-caret-right" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="item icon profile-balance-rc">
                                                <span class="coin">Point</span>
                                                @if($user->point!=null)
                                                    <span class="number font-bold rc-balance">{!! $user->point !!}</span>
                                                @else
                                                    <span><small class="no-rc-balance">(Hiện tại bạn không có Point nào)</small></span>
                                                @endif
                                                <i class="fas fa-caret-right" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('changeVotes') }}" class="item icon votes">
                                                <span class="text">Đổi phiếu</span>
                                                <i class="fas fa-caret-right" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        
                                        <li>
                                            <a href="{{ route('historyChap') }}" class="item icon">
                                                <span class="text">Tủ sách</span>
                                                <i class="fas fa-caret-right" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('indexNotice') }}" class="item icon">
                                                <span class="text">Thông báo</span>
                                                <i class="fas fa-caret-right" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        @can('comics.read')
                                        <li>
                                            <a href="{{ route('comicsAdmin') }}" class="item icon">
                                                <span class="text">Đăng truyện</span>
                                                <i class="fas fa-caret-right" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        @endcan
                                        
                                    </ul>
                                    <div class="img-vartar">
                                        @if($user->image)
                                            <a href="{{ route('editProfile') }}">{!! image($user->image, 40, 40, $user->name) !!}<span class="name">{{ $user->name }}</span></a>
                                        @else
                                            <a href="{{ route('editProfile') }}"><img src="{{ asset('public/images/avatar.png') }}" width="50" height="50" alt="avatar">
                                            <span>{{ $user->name }}</span>
                                            </a>
                                        @endif
                                         <a href="{{ route('logout') }}" class="logout"><i class="fas fa-sign-out-alt"></i>{{ __('Đăng xuất') }}</a>
                                    </div>
                                @else
                            <div class="log-res">
                                <a href="{{ route('storeLoginCustomer') }}" class="btn-muster"><span class="login">Đăng Nhập</span></a>
                                <a href="{{ route('storeRegisterCustomer') }}"><span class="register">Đăng Ký</span></a>
                                @endif
                            </div> 
                        </div>
                    </div>
                    @enddesktop
                </div>
            </header>
            <main>
                @yield('content')
            </main>
            <footer class="footer">
                <div class="container">
                    @php
                        $menu_footer = get_menu(14);
                    @endphp
                    @if(!$menu_footer->isEmpty())
                    <ul class="nav-footer">
                        @foreach($menu_footer as $menu)
                        <li><a href="{{get_link($menu->id)}}" {{($menu->target!="_self") ? 'target="'.$menu->target.'"' : ''}}>{{$menu->title}}</a></li>
                        @endforeach
                    </ul>
                    @endif
                    <div class="logo-comico">
                        {!! getLogoLight() !!}
                    </div>
                    <div class="link-face">
                        <a href="{{ facebook()}}"><img src="{{ asset('public/images/facebook.png') }}" alt="facebook"></a>
                    </div>
                     <script type="text/javascript"> 
                     (function () { var c = document.createElement('link'); c.type = 'text/css'; c.rel = 'stylesheet'; c.href = 'https://images.dmca.com/badges/dmca.css?ID=0ceb62cd-0741-4dc2-98f7-fff276b80550'; var h = document.getElementsByTagName("head")[0]; h.appendChild(c); })();</script>
                     <div class="dmca"> 
                        <div id="DMCA-badge">
                            <div class="dm-1 dm-1-b" style="left: 0px; background-color: rgb(241, 93, 98);"><a href="https://www.dmca.com/" title="DMCA">DMCA</a></div>
                            <div class="dm-2 dm-2-b"><a href="http://www.dmca.com/Protection/Status.aspx?ID=0ceb62cd-0741-4dc2-98f7-fff276b80550" title="DMCA">PROTECTED</a></div>
                        </div>
                     </div>
                <div class="copyright">
                    <div class="container"> 
                    {!! copyright() !!}
                    </div>
                </div>
            </footer>
{{--             @include('notices.index') --}}
            <div id="backtotop"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></div>
            <div id="overlay"></div>
            <div class="loading"><img src="{{ asset('public/images/loading_red.gif') }}" alt="loading..."></div>
        </div>
        <script type="text/javascript">(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.0&appId=1849189082054776&autoLogAppEvents=1';
            fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <script>
            /*<![CDATA[*/
            document.oncontextmenu = function () {
                return false;
            };
            /*]]>*/
        </script>
        <script type="text/javascript">
            /*<![CDATA[*/
            document.onselectstart = function () {
                event = event || window.event;
                var custom_input = event.target || event.srcElement;

                if (custom_input.type !== "text" && custom_input.type !== "textarea" && custom_input.type !== "password") {
                    return false;
                } else {
                    return true;
                }

            };
            if (window.sidebar) {
                document.onmousedown = function (e) {
                    var obj = e.target;
                    if (obj.tagName.toUpperCase() === 'SELECT'
                        || obj.tagName.toUpperCase() === "INPUT"
                        || obj.tagName.toUpperCase() === "TEXTAREA"
                        || obj.tagName.toUpperCase() === "PASSWORD") {
                        return true;
                    } else {
                        return false;
                    }
                };
            }
            window.onload = function () {
                document.body.style.webkitTouchCallout = 'none';
                document.body.style.KhtmlUserSelect = 'none';
            }
            /*]]>*/
        </script>
        <script type="text/javascript">
            /*<![CDATA[*/
            if (parent.frames.length > 0) {
                top.location.replace(document.location);
            }
            /*]]>*/
        </script>
        <script>
            /*<![CDATA[*/
            document.ondragstart = function () {
                return false;
            };
            /*]]>*/
        </script>
        <!--flatpickr-->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script type="text/javascript" src="{{ asset('public/js/flatpickr.js') }}"></script>
        <!--flatpickr-->
        <!-- Latest compiled and minified CSS -->
        <script type="text/javascript" src="{{ asset('public/js/timeago.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/pnotify.custom.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/popper.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/dropzone.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/jquery-ui.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/jquery.jscroll.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/owl.carousel.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/jquery.scrollbar.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/select2.full.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/jquery.raty.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/main.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/plus.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/sliders.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/profile.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/dsmart.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/comment.js') }}"></script>
        @yield('script')
        @handheld<script type="text/javascript" src="{{ asset('public/js/responsive.js') }}"></script>@endhandheld
    </body>
</html>