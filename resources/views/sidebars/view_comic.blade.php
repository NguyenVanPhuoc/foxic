<aside id="sb-hot" class="sb-comic">
    <div class="sb-title">
        <h3>{{ ($type_id == null) ? 'Truyện đang hot' : 'Truyện '.$type_title->title.' đang hot' }}</h3>
    </div>
    <div class="list-type">
        <ul class="nav nav-tabs">
        	<li class="active"><a href="#tabDate" data-toggle="tab">Ngày</a></li>
        	<li><a href="#tabMonth" data-toggle="tab">Tháng</a></li>
        	<li><a href="#tabAll" data-toggle="tab">All time</a></li>
        </ul>
        <div class="tab-content">
        	<div id="tabDate" class="tab-pane fade in active">
        		<ul>
        			@foreach($date_lists as $key=>$value)
                        <li>
                            <span>{{ $key+1 }}</span>
                            <a href="{{ route('listChap',$value->slug).'/' }}" title="{{ $value->title }}" class="title">{{ $value->title }}</a>
                            {!! getObjSlugTitleTypeInComic($value->id) !!}
                        </li>
                    @endforeach
        		</ul>
        	</div>
        	<div id="tabMonth" class="tab-pane fade in">
        		<ul>
        			@foreach($month_lists as $key=>$value)
                        <li>
                            <span>{{ $key+1 }}</span>
                            <a href="{{ route('listChap',$value->slug).'/' }}" title="{{ $value->title }}" class="title">{{ $value->title }}</a>
                            {!! getObjSlugTitleTypeInComic($value->id) !!}
                        </li>
                    @endforeach
        		</ul>
        	</div>
        	<div id="tabAll" class="tab-pane fade in">
        		<ul>
        			@foreach($lists as $key=>$value)
                        <li>
                            <span>{{ $key+1 }}</span>
                            <a href="{{ route('listChap',$value->slug).'/' }}" title="{{ $value->title }}" class="title">{{ $value->title }}</a>
                            {!! getObjSlugTitleTypeInComic($value->id) !!}
                        </li>
                    @endforeach
        		</ul>
        	</div>
        </div>
    </div>
</aside>