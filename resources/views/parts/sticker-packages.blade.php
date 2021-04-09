@if($sticker_packages)
	<ul class="list-packages">
		@if($sticker_packages->count() < $sticker_packages_count)
			<a href="{{ route('sticker.packages') }}" class="buy-packages"><i class="fa fa-plus"></i></a>
		@endif
		@foreach($sticker_packages as $package)
			<li class="item-package">
				<a href="javascript:void(0)" class="package-btn">{!! $package->stickers[0]->show_sticker() !!}</a>
				<ul class="list-stickers">
					@foreach($package->stickers as $sticker)
						@include('parts.sticker-item')
					@endforeach
				</ul>
			</li>
		@endforeach
	</ul>
@else
	<p class="notify">{{ 'Chưa có gói Stickers nào!' }}</p>
@endif