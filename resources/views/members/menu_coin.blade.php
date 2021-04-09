<div class="tabs-coin">
	<ul class="list-tabs">
		<li {{ (Route::currentRouteName() == 'addCoin') ? ' class=active' : '' }}><a href="{{ route('addCoin') }}">{{ __('Nạp point')}}</a></li>
		<li {{ (Route::currentRouteName() == 'historyPoint') ? ' class=active' : '' }}><a href="{{ route('historyPoint') }}">{{ __('Lịch sử Point')}}</a></li>
		<li {{ (Route::currentRouteName() == 'historyCoin') ? ' class=active' : '' }}><a href="{{ route('historyCoin') }}">{{ __('Lịch sử xu')}}</a></li>
	</ul>
</div>