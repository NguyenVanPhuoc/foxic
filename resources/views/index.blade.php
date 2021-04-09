@extends('templates.master')
@section('title', $page->title)
	@if($seo)
		@section('description', $seo->value)
		@section('keywords', $seo->key)
	@endif
@section('content')
	<div id="home" class="pages">
		@include('notices.index')
		@if($slide)
		@php 
	        $list_content = json_decode($slide->content);
	     @endphp
		<section class="slide-top">
			<div class="slide-banner owl-carousel">
				@foreach($list_content as $item)
				<div class="item" style="background-image: url('{!!getImgUrl($item->image)!!}');">
					<a href="{!!$item->link!!}" class="link-to"></a>
				</div>
				@endforeach
			</div>
		</section>
		@endif
		@php 
			$catMonopoly = getCatComic($catMonopolyId);
			$catHot = getCatComic($catHotId);
			$catFull = getCatComic($catFullId);
			$catNew = getCatComic($catNewId);
			$catNovel = getCatComic($catNovelId);
		@endphp
		<section id="hot">
			@if ($comicMonopoly != '' && $comicMonopoly->isNotEmpty())
			<div class="container">
				<div class="sec-title">
					<h2><a href="{{ route('catChap',['slug'=>$catMonopoly->slug]) }}">{{ _('Truyện độc quyền') }}</a></h2>
					<a href="{{ route('catChap',['slug'=>$catMonopoly->slug]) }}" >Xem thêm</a>
				</div>
				<div class="sec-content">
					<div class="list-hot clearfix">
						@foreach ($comicMonopoly as $comic) 
							<div class="item">
								<a href="{{ route('listChap',$comic->slug) }}">
									<div class="thumb-img">	
										{!! image($comic->image,181,220,$comic->title) !!}
									</div>
									<div class="title">
										<h3>{{ $comic->title }}</h3>
									</div>
								</a>
							</div>
						@endforeach
					</div>
				</div>
			</div>
			@endif
			@if ($comicCatHot != '' && $comicCatHot->isNotEmpty())	
			<div class="container">
				<div class="sec-title">
					<h2><a href="{{ route('catChap',['slug'=>$catHot->slug]) }}">{{ $catHot->title }}</a></h2>
					<a href="{{ route('catChap',['slug'=>$catHot->slug]) }}" >Xem thêm</a>
				</div>
				<div class="sec-content">
					<div class="list-hot clearfix">
						@foreach ($comicCatHot as $comic) 
							<div class="item">
								<a href="{{ route('listChap',$comic->slug) }}">
									<div class="thumb-img">	
										{!! image($comic->image,181,220,$comic->title) !!}
									</div>
									<div class="title">
										<h3>{{ $comic->title }}</h3>
									</div>
								</a>
							</div>
						@endforeach
					</div>
				</div>
			</div>
			@endif
		</section>
		<section id="novel">
			@if ($comicNovel != '' && $comicNovel->isNotEmpty())
				<div class="container">
					<div class="sec-title">
						<h2><a href="{{ route('catChap',['slug'=>$catNovel->slug]) }}">{{ _('Tiểu thuyết nổi bật') }}</a></h2>
						<a href="{{ route('catChap',['slug'=>$catNovel->slug]) }}" >Xem thêm</a>
					</div>
					<div class="list-novel">
						@foreach ($comicNovel as $comic) 
							<div class="item">
								<div class="thumb-img" style="background-image: url('{!! getImgUrl($comic->image) !!}');">
									<a href="{{ route('listChap',$comic->slug) }}" class="link"></a>
									<div class="title">
										<h3>{{ $comic->title }}</h3>
									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			@endif
		</section>
		<section id="new-up">
			@if ($comicCatFull != '' && $comicCatFull->isNotEmpty())
				<div class="container short">
					<div class="sec-title">
						<h2><a href="{{ route('catChap',['slug'=>$catFull->slug]) }}">{{ _('Truyện ngắn nổi bật') }}</a></h2>
						<a href="{{ route('catChap',['slug'=>$catFull->slug]) }}" >Xem thêm</a>
					</div>
					<div class="sec-content">
						<div class="list-hot clearfix">
							@foreach ($comicCatFull as $comic) 
								<div class="item">
									<a href="{{ route('listChap',$comic->slug) }}">
										<div class="thumb-img">	
											{!! image($comic->image,181,220,$comic->title) !!}
										</div>
										<div class="title">
											<h3>{{ $comic->title }}</h3>
										</div>
									</a>
								</div>
							@endforeach
						</div>
					</div>
				</div>
			@endif
				<div class="container">
					<div class="sec-title">
						<h2><a href="{{ route('comicNewChap') }}">{{ _('Truyện mới cập nhật') }}</a></h2>
						<a href="{{ route('comicNewChap') }}" >Xem thêm</a>
					</div>
					<div class="sec-content">
						<div class="list-hot clearfix">
							@foreach ($comicCatNew as $comic) 
								<div class="item">
									<a href="{{ route('listChap',$comic->slug) }}">
										<div class="thumb-img">	
											{!! image($comic->image,181,220,$comic->title) !!}
										</div>
										<div class="title">
											<h3>{{ $comic->title }}</h3>
										</div>
									</a>
								</div>
							@endforeach
						</div>
					</div>
				</div>
		</section>
		<section id="wrapper-ranking">
			@if ($comicVotes != '' && $comicVotes->isNotEmpty())
				<div class="container">
					<div class="sec-title">
						<h2>{{ _('Bảng xếp hạng') }}</h2>
					</div>
					<div class="list-ranking row">
						@foreach ($comicVotes as $key => $comic) 
							<div class="item {{ $key >= 2 ? "col-md-4" : "col-md-6"}}">
								<figure class="card">
									<i class="fa fa-bookmark" aria-hidden="true"><span>{{ $key+1 }}</span></i>
                                   	<div class="thumb-img">	
                                   		<a class="link-comic" href="{{ route('listChap',$comic->slug)}}"></a>
										{!! image($comic->image,181,181,$comic->title) !!}
									</div>
                                    <figcaption class="card-body">
                                        <h4 class="card-title">{{ $comic->title }}</h4>
                                        <div class="card-text">{!! $comic->desc !!}</div>
                                    </figcaption>
                                </figure>
							</div>
						@endforeach
					</div>
				</div>
			@endif
		</section>
		<section id="suggestions">
			@if ($comicRandom != '' && $comicRandom->isNotEmpty())
				<div class="container sugges-write">
					<div class="sec-title">
						<h2>{{ _('GỢI Ý TỪ BAN BIÊN TẬP') }}</h2>
					</div>
					<div class="sec-content">
						<div class="list-hot clearfix">
							@foreach ($comicRandom as $comic) 
								<div class="item">
									<a href="{{ route('listChap',$comic->slug) }}">
										<div class="thumb-img">	
											{!! image($comic->image,181,220,$comic->title) !!}
										</div>
										<div class="title">
											<h3>{{ $comic->title }}</h3>
										</div>
									</a>
								</div>
							@endforeach
						</div>
					</div>
				</div>
			@endif
		</section>
		
	</div>
@endsection