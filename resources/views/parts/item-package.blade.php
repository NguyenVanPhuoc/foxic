@if($package)
	<div class="item-package">
		<a href="javascript:void(0)" class="package-btn">
			<span>{{ $package->stickers_count }}</span>
			{!! $package->stickers[0]->show_sticker(100, 100) !!}
		</a>
		<h4 class="package-title">{{ $package->title }}</h4>
		@if(Auth::check())
			@if($package->userCanUse(Auth::id()))
				<a href="javascript:void(0)" class="btn btn-cs" disabled>{{ $package->amount <= 0 ? __('Free') : __('Đã thêm') }}</a>
			@else
				<a href="{{ route('sticker.buy_package',['package_id'=>$package->id]) }}" class="btn btn-cs">{!! __('Thêm <small>(').$package->amount.' points)</small>' !!}</a>
			@endif
		@else
			<a href="{{ route('storeLoginCustomer') }}" class="btn btn-cs">{!! __('Thêm <small>(').$package->amount.' points)</small>' !!}</a>
		@endif
		<ul class="list-stickers">
			@foreach($package->stickers as $sticker)
				<li>{!! $sticker->show_sticker(70,70) !!}</li>
			@endforeach
		</ul>
	</div>
@endif