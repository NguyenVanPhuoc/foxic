@php $packages = getPackages(); @endphp
<ul class="pro-menu">
    <li><a href="{{route('newsProfile')}}"{{ Request::is('profile/news') ? ' class=active' : '' }}>Tất cả tin</a></li>
    <li><a href="{{route('listLikeNewsProfile')}}"{{ Request::is('profile/news/tin-yeu-thich') ? ' class=active' : '' }}>Tin yêu thích</a></li>
    @if($packages)		
        @foreach($packages as $item)
            <li><a href="{{route('vipNewsProfile',['vip'=>$item->slug])}}"<?php if(url()->current()==url('profile/vip/'.$item->slug)) echo ' class="active"'?>>{{$item->title}}</a></li>
        @endforeach
    @endif
</ul>