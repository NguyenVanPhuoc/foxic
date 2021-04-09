@extends('templates.master')
@section('title','Stickers')
@section('content')
<div class="page stickers">
	<div class="container">
		<div class="row">
			<div id="content" class="col-md-8">
                <div class="page-title text-center">
                	<h2>{{ __('Stickers') }}</h2>
                </div>
                @include('notices.index')
                <div class="list-packages packages">
                	@foreach($sticker_packages as $package)
                		@include('parts.item-package')
                	@endforeach
                </div>
                <div class="text-center">
                    {{ $sticker_packages->links() }}
                </div>             
            </div>
	        <div id="sidebar" class="col-md-4">
	            <aside id="sb-type" class="sb-comic">
	                <div class="sb-title">
	                    <h3>{{ __('Thể loại truyện') }}</h3>
	                </div>
	                <div class="list-type row">
	                    @php $typeComics = getListTypeComic();@endphp
	                    @foreach ($typeComics as $type)
	                        <div class="item col-md-6">
	                            <a href="{{ route('typeChap',['slug'=>$type->slug]) }}">{{ $type->title }}</a>
	                        </div>
	                    @endforeach   
	                </div>
	            </aside>
	            {!! getListHotComic() !!}    
	        </div>  
		</div>
	</div>
</div>	
@endsection