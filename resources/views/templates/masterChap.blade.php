<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="nue2yPo8zEhxFTqyvWcherHQKvZKV0hwAS04gkFBN2g" />
        <title>@yield('title')</title>
        <meta http-equiv="Content-Language" content="en"/>
        <meta name="description" content="@yield('description')"/>
        <meta name="keywords" content="@yield('keywords')"/>
        <link rel="shortcut icon" href="{{ favicon() }}">

        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/normalize.css') }}" >
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/bootstrap.min.css') }}" >
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/owl.theme.default.min.css') }}">
        <!--flatpickr-->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">
        <!--flatpickr-->
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/jquery-ui.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/pnotify.custom.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/scrollbar.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/all.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/checkbox_radio.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/style.css') }}" >
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/main.css') }}">
        @handheld <link rel="stylesheet" href="{{ asset('public/css/responsive.css') }}">@endhandheld
    </head>
    <body class="viewer-chap">
        <div id="fb-root"></div>
        <div id="wrapper">
            <header>
                <div class="container flex item-center content-center">
                    <figure id="logo"><a href="{{ route('home').'/' }}">{!! getLogoChap() !!}</a></figure>
                    <ul class="menu-left list-unstyled flex item-center content-center">
                        <li><a href="{{ route('listChap',['slug'=>$comic->slug]).'/' }}">{{ $comic->title }}<span>{{ $chap->title }}</span></a></li>
                    </ul>
                </div>
            </header>
            <main>
                @yield('content')
            </main>
            <footer>
                @php 
                    $numEpiBelow = intval($chap->position) - 1; 
                    $numEpiUp = intval($chap->position) + 1;
                    $user = Auth::user();
                    $totalChap = intval($total) - 1;
                @endphp
                <div class="container">
                    <ul class="list-action list-unstyled clearfix flex item-center content-center">
                        <li class="btn-prev"><a @if(intval($chap->position) == 0) class="disabled" @else href="{{ route('detailChap',['slugComic'=>$comic->slug, 'chap'=>$numEpiBelow ]).'/' }}" @endif><i class="far fa-chevron-left"></i>{{ _('Prev') }}</a></li>
                        <li class="btn-list"><a href="{{ route('listChap',['slug'=>$comic->slug]).'/' }}"><i class="far fa-list"></i></a></li>
                        <li class="btn-next">
                            <a
                            @if ($numEpiUp <= $totalChap )
                                @if(checkTypeUserChapByPosition($numEpiUp) == 'free') href="{{ route('detailChap',['slugComic'=>$comic->slug, 'chap'=>$numEpiUp ]).'/' }}" 
                                @else
                                    @if (checkTypeUserChapByPosition($numEpiUp) == 'member')
                                        @if (Auth::check() && ($user->level == 'member' || $user->level == 'admin'))
                                            href="{{ route('detailChap',['slugComic'=>$comic->slug, 'chap'=>$numEpiUp ]).'/' }}"
                                        @else
                                            href="{{ route('login').'/' }}"
                                        @endif
                                    @else 
                                        @if (Auth::check() && $user->level == 'admin')
                                            href="{{ route('detailChap',['slugComic'=>$comic->slug, 'chap'=>$numEpiUp ]).'/' }}"
                                        @else
                                            @if (Auth::check() && $user->level != 'admin')
                                                href="{{ route('vipPackages').'/' }}"
                                            @else
                                                href="{{ route('login').'/' }}"
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            @else
                                class="disabled"
                            @endif
                        >{{ _('Next') }}<i class="far fa-chevron-right"></i></a></li>
                    </ul>
                </div>
            </footer>
            <div id="overlay"></div>
            <div class="loading"><img src="{{ asset('public/images/loading_red.gif') }}" alt="loading..."></div>
        </div>
        <script type="text/javascript" src="{{ asset('public/js/jquery.min.js') }}"></script>
        <script type="text/javascript">(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.0&appId=1849189082054776&autoLogAppEvents=1';
            fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
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
        <script type="text/javascript" src="{{ asset('public/js/jquery-ui.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/jquery.jscroll.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/owl.carousel.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/jquery.scrollbar.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/main.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/sliders.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/profile.js') }}"></script>
        @yield('script')
        @handheld<script type="text/javascript" src="{{ asset('public/js/responsive.js') }}"></script>@endhandheld
    </body>
</html>