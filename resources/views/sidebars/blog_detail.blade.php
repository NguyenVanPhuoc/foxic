@php $categories = get_categories();
	$view = getAds(16);
	$cat = get_category($blog->cat_id);
	$cat_slug = empty($cat)? '' : $cat->slug;	
	$author = getUser($blog->user_id);
	$dateAuthor = dateConvert($author->created_at);
	$view = getAds(16);
@endphp
<aside id="author-info" class="sb-slide">
	<div class="desc">
		<div class="info clearfix">
			<figure class="thumb">{!!image($author->image,106,106,$author->name)!!}</figure>
			<div class="sub-desc">
				<p class="name">{{$author->name}}</p>
				<ul class='list-unstyled'>
					<li><img src="{{asset('public/images/calendar-author.png')}}" alt="icon">{{$dateAuthor}}</li>
					<li><img src="{{asset('public/images/list-author.png')}}" alt="icon">{{count_aritcleUser($author->id)}} bài viết</li>
				</ul>	
			</div>	    
	    </div>	    
    </div>
</aside>
@if($view)
<aside id="sb-view" class="sb-slide hide-991">
	<h3 class="sb-title"><span>Tin quảng cáo</span></h3>	
	<div class="desc">{!! $view->content !!}</div>
</aside>
@endif
@if($categories)
<aside id="sb-categories">
	<h3 class="sb-title"><span>Danh mục</span></h3>
	<div class="desc">
		<ul class="list-cat">
			@foreach($categories as $item)
			<li<?php if($cat_slug==$item->slug) echo ' class="active"';?>><a href="{{$item->slug}}"><i class="fas fa-circle"></i>{{$item->title}}</a></li>
			@endforeach
		</ul>
	</div>
</aside>
@endif