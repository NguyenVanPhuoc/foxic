@if(Auth::check())
<?php 
    $user = Auth::User();
?>
<div class="right-header">
    <div class="bell">
        <span class="toggle-bell"><i class="fas fa-bell"></i></span>
        @if(count($user->unreadNotifications)>0)
        <span class="number-noti">{{count($user->unreadNotifications)}}</span>
        @endif
        <ul class="dropdown-bell hide">
            @if(count($user->unreadNotifications)>0)
                @foreach ($user->unreadNotifications as $key =>$notification)
                    @php 
                        if($key>=5)
                        break;
                        $notify = $notification->data;
                    @endphp
                    @foreach($notify as $item)
                    @php
                        $notice = getNoticeById($item);
                    @endphp
                        <li>
                            <a href="{{ route('detailNotice',['slug'=>$notice->slug]) }}">{{ $notice->title }}</a>
                            <span class="datetime">{{timeElapsedString($notification->created_at)}}</span>
                        </li>
                    @endforeach
                @endforeach
                @if(count($user->unreadNotifications) > 5)
                    <a href="{{ route('indexNotice') }}" class="more"><span>{{ __('Xem thêm')}}</span></a>
                @endif
            @else
            <li>
                <span class="noduble">{{ __('Không có thông báo nào! ')}}</span>
            </li>
            @endif
        </ul>
    </div>
    <ul class="navbar-right">
        <li><i class="fa fa-user"></i> <strong>{{$user->name}}</strong></li>
        <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i>Đăng xuất</a></li>
        @handheld<li class="mobi-nav-icon"><i class="fa fa-bars" aria-hidden="true"></i></li> @endhandheld
    </ul>
</div>
<p class="welcome">Xin chào <a href="#">{{$user->name}}</a></p>
@endif