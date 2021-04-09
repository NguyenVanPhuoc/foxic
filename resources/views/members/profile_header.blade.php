<div id="pro-asMenu">
	<ul class="action list-unstyled">
		<li {{ (Route::currentRouteName() == 'editProfile') ? ' class=active' : '' }}><a href="{{ route('editProfile') }}">{{ _('Cập nhật') }}</a></li>
		<li {{ (Route::currentRouteName() == 'editPassword') ? ' class=active' : '' }}><a href="{{ route('editPassword') }}">{{ _('Mật khẩu') }}</a></li>
		<li><a href="{{ route('changeVotes') }}">{{ _('Đổi phiếu') }}</a></li>
		<li><a href="{{ route('historyChap') }}">{{ _('Tủ sách') }}</a></li>
	</ul>
</div>