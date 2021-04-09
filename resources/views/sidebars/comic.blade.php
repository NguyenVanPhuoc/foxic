@if (count($listCatComicIds) > 0 && count($listCatComicIds) <= 2)
    @foreach($listCatComicIds as $CatId)
        @php $catComic = getCatComic($CatId); @endphp
        <aside id="{{ $catComic->slug }}" class="sb-comic">
            <h3 class="sb-title">{!! imageAuto($catComic->icon,$catComic->showTitle()) !!}{{ $catComic->showTitle() }}</h3>
            <div class="list-comics list-unstyled">
                @php 
                    $listComic = getListComicInCat($CatId);
                    $totalListComic = 3;
                    if(count($listComic) < 3) $totalListComic = count($listComic);
                @endphp
                @for ($i = 0; $i < $totalListComic; $i++)
                    @php $comic = $listComic[$i]; @endphp
                    @if ($status == 'off')
                        @php 
                            $typePlusArr = explode(',',$comic->type_plus);
                            $flag = false;
                            foreach ($typePlusArr as $type_plus) {
                                if ($type_plus == '18+') {
                                    $flag = true;
                                }
                            }
                        @endphp
                        @if ( $flag == true)
                            @if ($i < 3)
                                <div class="sb-item flex">
                                    <figure class="image">
                                        <a href="{{ route('listChap',['slug'=>$comic->slug]).'/' }}">{!! image($comic->image, 100, 148, $comic->showTitle()) !!}</a>
                                        @if ($comic->type_plus != '')
                                            <ul class="status clearfix list-unstyled">
                                                @php $arrTypePlus = explode(',',$comic->type_plus); @endphp
                                                @if (count($arrTypePlus) > 0 && $arrTypePlus != '')
                                                    @foreach ($arrTypePlus as $typePlus)
                                                        @if ($typePlus) <li class={{ $typePlus }}>{{ $typePlus }}</li> @endif
                                                    @endforeach
                                                @endif
                                            </ul>
                                        @endif
                                    </figure>
                                    <div class="desc">
                                        <h4>{{ $comic->title }}</h4>
                                        <ul class="meta list-unstyled flex item-center content-start">
                                            @php $listTypes = getObjTitleColorTypeInComic($comic->id); $count = 0;@endphp
                                            @foreach ($listTypes as $item)
                                                @php $count ++; @endphp
                                                <li @if($count > 1) class="active" @endif>{{ $item->showTitle() }}</li>
                                            @endforeach
                                        </ul>
                                        <p>{!! $comic->excerpt !!}</p>
                                    </div>
                                </div>
                            @else
                                @php
                                    break;
                                @endphp
                            @endif
                        @endif
                    @else
                        @php 
                            $typePlusArr = explode(',',$comic->type_plus);
                            $flag = false;
                            foreach ($typePlusArr as $type_plus) {
                                if ($type_plus == '18+') {
                                    $flag = true;
                                }
                            }
                        @endphp
                        @if ($flag == false)
                            @if ($i < 3)
                                <div class="sb-item flex">
                                    <figure class="image">
                                        <a href="{{ route('listChap',['slug'=>$comic->slug]).'/' }}">{!! image($comic->image, 100, 148, $comic->showTitle()) !!}</a>
                                        @if ($comic->type_plus != '')
                                            <ul class="status clearfix list-unstyled">
                                                @php $arrTypePlus = explode(',',$comic->type_plus); @endphp
                                                @if (count($arrTypePlus) > 0 && $arrTypePlus != '')
                                                    @foreach ($arrTypePlus as $typePlus)
                                                        @if ($typePlus)
                                                            <li class={{ $typePlus }}>{{ $typePlus }}</li>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </ul>
                                        @endif
                                    </figure>
                                    <div class="desc">
                                        <h4>{{ $comic->title }}</h4>
                                        <ul class="meta list-unstyled flex item-center content-start">
                                            @php $listTypes = getObjTitleColorTypeInComic($comic->id); $count = 0;@endphp
                                            @foreach ($listTypes as $item)
                                                @php $count ++; @endphp
                                                <li @if($count > 1) class="active" @endif>{{ $item->showTitle() }}</li>
                                            @endforeach
                                        </ul>
                                        <p>{!! $comic->excerpt !!}</p>
                                    </div>
                                </div>
                            @else
                                @php
                                    break;
                                @endphp
                            @endif
                        @endif
                        
                    @endif
                @endfor
            </div>
        </aside>
    @endforeach
@endif