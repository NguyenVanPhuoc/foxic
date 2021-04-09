@if($categories)
	<div class="sb-box list-cat">
		<h3 class="title-box">Danh mục</h3>
		<ul class="list-item list-unstyled">
			{!! getCatProducts($categories,0) !!}
		</ul>
	</div>
@endif

@if($proBestSell)
	<div class="sb-box list-post list-best-sell">
		<h3 class="title-box">Sản phẩm bán chạy</h3>
		<div class="list-item">
			@foreach ($proBestSell as $pro)
				<div class="item">
					<a href="{{ route('product', ['slug'=>$pro->slug]) }}" class="thumb">
						{!! image($pro->image, 85, 85, $pro->title) !!}
					</a>
					<div class="desc">
						<h4 class="title">
							<a href="{{ route('product', ['slug'=>$pro->slug]) }}">{{ $pro->title }}</a>
						</h4>
						<div class="price">{!! getPriceSecPro($pro->id) !!}</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endif