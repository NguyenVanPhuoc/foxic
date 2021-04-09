@extends('templates.master')
@section('title', $notice->title)
@section('keywords', 'notice')
@section('description','notice')
@section('content')
    <div id="notice" class="pages detail-notice">
        <div class="container">
            <div class="item-notice">
                <div class="thumb_img" style="background-image: url('{!!getImgUrl($notice->image)!!}');"></div>
                <div class="desc">
                    <h3 class="title">{{$notice->title}}</h3>
                    <p>{{ __('Thời gian:')}} {{ date_format(date_create($notice->created_at), 'd-m-Y H:i:s') }}</p>
                    {!! $notice->content !!}
                </div>
            </div>
        </div>
    </div>
@endsection