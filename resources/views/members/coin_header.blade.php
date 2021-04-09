<div class="coin-current">
	@php 
        $user = getCurrentUser();
    @endphp
	<div class="account item">
		<p>{{ __('Tài khoản: ')}}{{ $user->name }}</p>
		<h3>{{ __('Số point hiện tại')}}</h3>
	</div>
	<div class="coin-item-current item">
		<p class="font-bold">{{ __('Tổng số point')}} </p>
		<div class="number">
			<img src="{{ asset('public/images/icons/img-point.png') }}" alt="point">
			<span class="font-bold orange">{{ $user->point }}</span>
		</div>
	</div>
	<div class="coin-item-current item">
		<p class="font-bold">{{ __('Tổng số xu')}} </p>
		<div class="number">
			<img src="{{ asset('public/images/icons/copyright.png') }}" alt="coin">
			<span class="font-bold orange">{{ $user->coin }}</span>
		</div>
	</div>
</div>