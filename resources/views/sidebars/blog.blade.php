@php
	$categories = get_categories();
	$views = get_blogByView(8);
	$cat_slug = empty($cat)? '' : $cat->slug;	
@endphp
@if($categories->isNotEmpty())
	<aside id="sb-categories">
		<h3 class="sb-title"><span>Danh mục</span></h3>
		<div class="desc">
			<ul class="list-cat">
				@foreach($categories as $item)
				<li <?php if($cat_slug==$item->slug) echo ' class="active"';?>><a href="{{ route('categoryBlog',['slug'=>$item->slug ]).'/' }}"><i class="fas fa-circle"></i>{{$item->title}}</a></li>
				@endforeach
			</ul>
		</div>
	</aside>
@endif
@if($views->isNotEmpty())
	<aside id="sb-view" class="sb-slide">
		<h3 class="sb-title"><span>Tin xem nhiều</span></h3>	
		<div class="desc">
			<ul class="list">
				@foreach($views as $item)
					<li>
						<a class="thumb" href="{{ route('detailBlog',['slug'=>$item->slug]).'/' }}">{!! image($item->image,60,60,$item->title) !!}</a>
						<h4>
							<a href="{{ route('detailBlog',['slug'=>$item->slug]).'/' }}">{{ $item->title }}</a>
							<span><i class="fa fa-eye" aria-hidden="true"></i> {{ $item->view }}</span>
						</h4>
					</li>
				@endforeach
			</ul>
		</div>
	</aside>
@endif