<div class="nav-default">
	<div class="container">
		<div class="box-img">
	        <img src="{{ asset('public/images/icons/books.png') }}" alt="voucher">
	        <span class="font-bold">Tủ sách của bạn</span>
	    </div>
		<ul class="nav-link">
			<li {{ (Route::currentRouteName() == 'historyChap') ? ' class=active' : '' }}><a href="{{ route('historyChap') }}">{{ __('Lịch sử đọc truyện')}}</a></li>
			<li {{ (Route::currentRouteName() == 'buyChaps') ? ' class=active' : '' }}><a href="{{ route('buyChaps') }}">{{ __('Truyện đã mua')}}</a></li>
			<li {{ (Route::currentRouteName() == 'rentalChaps') ? ' class=active' : '' }}><a href="{{ route('rentalChaps') }}">{{ __('Truyện đã thuê')}}</a></li>
		</ul>
	</div>
</div>