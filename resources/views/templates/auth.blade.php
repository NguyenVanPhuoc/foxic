<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Toomics">
        <meta name="author" content="Vietsmiler">
        <title>@yield('title')</title>       
        <link rel="shortcut icon" href="{{ favicon() }}">
        {{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous"> --}}
        {{-- <link rel="stylesheet" type="text/css" href="{{ asset('public/bootstrap/css/bootstrap.min.css') }}"> --}}
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/all.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/style.css') }}" >
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/auth.css') }}" >
        @handheld <link rel="stylesheet" type="text/css" href="{{ asset('public/css/responsive.css') }}"> @endhandheld
        <link rel="stylesheet" href="{{ asset('public/css/checkbox_radio.css') }}">
        <link rel="stylesheet" href="{{ asset('public/css/pnotify.custom.min.css') }}">
        {{-- <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script> --}}
        <script type="text/javascript" src="{{ asset('public/js/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/pnotify.custom.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/js/author.js') }}"></script>
    </head>
    <body>
        <div id="wrapper"> @yield('content') </div>
    </body>
    <div id="overlay"></div>
    <div class="loading"><img src="{{ asset('public/images/loading_red.gif') }}" alt="loading..."></div>
    <script type="text/javascript" src="{{ asset('public/js/validator.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/validator.min.js') }}" ></script>
</html>