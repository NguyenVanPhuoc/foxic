<?php
use App\Comic;
use App\CategoryComic;
use App\TypeComic;
use App\Writer;
use App\Artist;
use App\ComicCat;
use App\ComicType;
use App\ComicWriter;
use App\ComicArtist;
use App\MediaComic;
use App\ViewComic;
use App\Media;
use App\Metas;
use App\User;

/*
* get comic by id
* @param $id
*/
if(!function_exists('getComicById')){
	function getComicById($id){
		return Comic::where('id', $id)->first(); 
	}
}
/*
* get list text category in comic
* @param $comic_id
*/
if(!function_exists('getListTextCatInComic')){
	function getListTextCatInComic($comic_id){
		$array_catID = ComicCat::where('comic_id', $comic_id)->pluck('cat_id')->toArray(); 
		// $array_catTitle = CategoryComic::whereIn('id', $array_catID)->pluck('title')->toArray(); 
		// return implode(", ", $array_catTitle);
		$array_catTitle = CategoryComic::select('id', 'title')->whereIn('id', $array_catID)->get();
		$result = '';
		if($array_catTitle) {
			foreach ($array_catTitle as $key => $value) {
				if($key != 0) $result .= ', '.$value->showTitle();
					else $result .= $value->showTitle();
			}
		}
		return $result;
	}
}

/*
* get list text type in comic
* @param $comic_id
*/
if(!function_exists('getListTextTypeInComic')){
	function getListTextTypeInComic($comic_id){
		$array_typeID = ComicType::where('comic_id', $comic_id)->pluck('type_id')->toArray();
		// $array_typeTitle = TypeComic::whereIn('id', $array_typeID)->pluck('title')->toArray();
		// return implode(", ", $array_typeTitle);
		$array_typeTitle = TypeComic::select('id', 'title')->whereIn('id', $array_typeID)->get();
		$result = '';
		if($array_typeTitle) {
			foreach ($array_typeTitle as $key => $value) {
				if($key != 0) $result .= ', '.$value->showTitle();
					else $result .= $value->showTitle();
			}
		}
		return $result;
	}
}


/*
* get list text writer in comic
* @param $comic_id
*/
if(!function_exists('getListTextWriterInComic')){
	function getListTextWriterInComic($comic_id){
		$array_writerID = ComicWriter::where('comic_id', $comic_id)->pluck('writer_id')->toArray();
		// $array_writerTitle = Writer::whereIn('id', $array_writerID)->pluck('title')->toArray();
		// return implode(", ", $array_writerTitle);
		$array_writerTitle = Writer::select('id', 'title')->whereIn('id', $array_writerID)->get();
		$result = '';
		if($array_writerTitle) {
			foreach ($array_writerTitle as $key => $value) {
				if($key != 0) $result .= ', '.$value->show_name();
					else $result .= $value->show_name();
			}
		}
		return $result;
	}
}
/*
* get list text artist in comic
* @param $comic_id
*/
if(!function_exists('getListTextArtistInComic')){
	function getListTextArtistInComic($comic_id){
		$array_artistID = ComicArtist::where('comic_id', $comic_id)->pluck('artist_id')->toArray();
		// $array_artistTitle = Artist::whereIn('id', $array_artistID)->pluck('title')->toArray();
		// return implode(", ", $array_artistTitle);
		$array_artistTitle = Artist::select('id', 'title')->whereIn('id', $array_artistID)->get();
		$result = '';
		if($array_artistTitle) {
			foreach ($array_artistTitle as $key => $value) {
				if($key != 0) $result .= ', '.$value->show_name();
					else $result .= $value->show_name();
			}
		}
		return $result;
	}
}
/*
* get array title category in comic, return array tilte category
* @param $comic_id
*/
if(!function_exists('getArrayTitleCatInComic')){
	function getArrayTitleCatInComic($comic_id){
		$array_catID = ComicCat::where('comic_id', $comic_id)->pluck('cat_id')->toArray(); 
		$array_catTitle = CategoryComic::whereIn('id', $array_catID)->pluck('title')->toArray(); 
		return $array_catTitle;
	}
}

/*
* get array title type in comic, return array tilte type
* @param $comic_id
*/
if(!function_exists('getArrayTitleTypeInComic')){
	function getArrayTitleTypeInComic($comic_id){
		$array_typeID = ComicType::where('comic_id', $comic_id)->pluck('type_id')->toArray();
		$array_typeTitle = TypeComic::whereIn('id', $array_typeID)->pluck('title')->toArray();
		return $array_typeTitle;
	}
}
/**
* get object title, slug type in comic, return object tilte. slug
* @param $comic_id
*/
if(! function_exists('getObjSlugTitleTypeInComic')){
	function getObjSlugTitleTypeInComic($comic_id){
		$array_typeID = ComicType::where('comic_id', $comic_id)->pluck('type_id')->toArray();
		$array_typeTitle = TypeComic::whereIn('id', $array_typeID)->select('id', 'title', 'slug')->get();
		$html = '';
		$count = 0;
		$comma = '';
		foreach ($array_typeTitle as $type) {
			$count++;
			if($count > 1) $comma = ', ';
			else  $comma = '';
			$html .= $comma.'<a href="'.route("typeChap",$type->slug).'/'.'">'.$type->showTitle().'</a>';
		}
		return $html;
	}
}

/*
* get array title writer in comic, return array tilte writer
* @param $comic_id
*/
if(!function_exists('getArrayTitleWriterInComic')){
	function getArrayTitleWriterInComic($comic_id){
		$array_writerID = ComicWriter::where('comic_id', $comic_id)->pluck('writer_id')->toArray();
		$array_writerTitle = Writer::whereIn('id', $array_writerID)->pluck('title')->toArray();
		return $array_writerTitle;
	}
}
/*
* get object title, slug writer in comic, return object tilte. slug
* @param $comic_id
*/
if(! function_exists('getObjSlugTitleWriterInComic')){
	function getObjSlugTitleWriterInComic($comic_id){
		$array_writerID = ComicWriter::where('comic_id', $comic_id)->pluck('writer_id')->toArray();
		$array_writerTitle = Writer::whereIn('id', $array_writerID)->select('id', 'title','slug')->get();
		$html = '';
		$count = 0;
		$comma = '';
		foreach ($array_writerTitle as $type) {
			$count++;
			if($count > 1) $comma = ', ';
			else  $comma = '';
			$html .= $comma.'<a href="'.route('comicWriter',$type->slug).'/'.'">'.$type->show_name().'</a>';
		}
		return $html;
	}
}
/*
* get object title, slug artist in comic, return object tilte. slug
* @param $comic_id
*/
if(! function_exists('getObjSlugTitleArtistInComic')){
	function getObjSlugTitleArtistInComic($comic_id){
		$array_artistID = ComicArtist::where('comic_id', $comic_id)->pluck('artist_id')->toArray();
		$array_artistTitle = Artist::whereIn('id', $array_artistID)->select('id', 'title','slug')->get();
		$html = '';
		$count = 0;
		$comma = '';
		foreach ($array_artistTitle as $type) {
			$count++;
			if($count > 1) $comma = ', ';
			else  $comma = '';
			$html .= $comma.'<span>'.$type->show_name().'</span>';
		}
		return $html;
	}
}
/*
* get array title type plus in comic, return array tilte type plus
* @param $comic_id
*/
if(!function_exists('getArrayTitleTypePlusInComic')){
	function getArrayTitleTypePlusInComic($comic_id){
		$comic = Comic::findOrFail($comic_id);
		$array_title = [];
		$list_typePlus = config('data_config.type_plus_comic');
		$array_typePlus = explode(",", $comic->type_plus);
		foreach($list_typePlus as $item){
			if(in_array($item['value'], $array_typePlus))
				$array_title[] = $item['title'];
		}
		return $array_title;
	}
}

/*
* get list comic in category id
* @param $comic_id
*/
if(!function_exists('getListComicInCat')){
	function getListComicInCat($cat_id){
		$comics = Comic::join('comic_cats','comics.id','=','comic_cats.comic_id')
			->where('comic_cats.cat_id',$cat_id)->status()
			->distinct()->select('comics.id as id', 'comics.title as title', 'comics.user_id as user_id','comics.image as image', 'comics.slug as slug', 'comics.end as end', 'comics.chap_up as chap_up')
			->orderBy('chap_up','desc')->paginate(14);
		return $comics;
	}
}

/*
* get list comic in category id
* @param $comic_id
*/
if(!function_exists('getListComicInCatV1')){
	function getListComicInCatV1($cat_id){
		$comics = Comic::join('comic_cats','comics.id','=','comic_cats.comic_id')
                ->join('category_comics','category_comics.id','=','comic_cats.cat_id')
                ->where('comic_cats.cat_id',$cat_id)
                ->status()
                ->distinct()
                ->select('comics.id as id', 'comics.title as title','comics.slug as slug','comics.image as image', 'comics.created_at as created_at')
                ->orderBy('comics.created_at','desc')
                ->limit(6)
                ->get();
		return $comics;
	}
}
/*
* get object both title, color type in comic, return object tilte, color type
* @param $comic_id
*/
if(!function_exists('getObjTitleColorTypeInComic')){
	function getObjTitleColorTypeInComic($comic_id){
		$array_typeID = ComicType::where('comic_id', $comic_id)->pluck('type_id')->toArray();
		$array_typeTitle = TypeComic::whereIn('id', $array_typeID)->select('title','color')->get();
		return $array_typeTitle;
	}
}
/*
* get object both title, slug type in comic, return object tilte, slug type
* @param $comic_id
*/
if(!function_exists('getObjTitleSlugTypeInComic')){
	function getObjTitleSlugTypeInComic($comic_id){
		$array_typeID = ComicType::where('comic_id', $comic_id)->pluck('type_id')->toArray();
		$array_typeTitle = TypeComic::whereIn('id', $array_typeID)->select('title','slug')->get();
		return $array_typeTitle;
	}
}

/*
* get list old media of comic
* @param $comic_id, int $skip, int $limit
* @return list object media
*/
if(! function_exists('getListOldMediaOfComic')){
	function getListOldMediaOfComic($comic_id, $skip = false, $limit = false){
		$media_comicID = MediaComic::where('image_of', 'comic')->where('post_id', $comic_id)->pluck('media_id')->toArray();
		if($skip && $limit)
			$list_media = Media::whereIn('id', $media_comicID)->latest()->skip($skip)->limit($limit)->get(); 
		else
			$list_media = Media::whereIn('id', $media_comicID)->latest()->get(); 
		return $list_media;
	}
}

/*
* get list comic in type id
* @param $comic_id

*/
if(!function_exists('getListComicInType')){
	function getListComicInType($type_id){
		$comics = Comic::join('comic_types','comics.id','=','comic_types.comic_id')
			->where('comic_types.type_id',$type_id)->status()
			->distinct()->select('comics.id as id', 'comics.title as title', 'comics.image as image' , 'comics.slug as slug', 'comics.end as end', 'comics.chap_up as chap_up')
			->orderBy('chap_up','desc')->paginate(16);
		return $comics;
	}
}

/*
* get list comics with same writer
* @param $comic_id
*/	
if(!function_exists('getListComicSameWriter')){
	function getListComicSameWriter($comic_id){
		$array_writerID = ComicWriter::where('comic_id', $comic_id)->pluck('writer_id')->toArray();
		$comicIDs = Comic::join('comic_writers','comics.id','=','comic_writers.comic_id')
					->whereIn('comic_writers.writer_id', $array_writerID)
					->whereNotIn('comic_writers.comic_id',[$comic_id])
					->distinct()->select('comics.title as title', 'comics.slug as slug', 'comics.chap_up as chap_up')
					->orderBy('chap_up','desc')->paginate(10);
		return $comicIDs;
	}
}
/*
* Show HOT comic
* @param type
*/	
if(!function_exists('getListHotComic')){
	function getListHotComic($type_id=null){					
		$data = [];
		if ($type_id != null) {
			$type_title = TypeComic::where('id',$type_id)->select('title')->first();
			$data['type_title'] = $type_title;
		}	
		$date_lists = ViewComic::join('comics','view_comics.comic_id','=','comics.id');
		if ($type_id != null) {
			$date_lists = $date_lists->join('comic_types','comics.id','=','comic_types.comic_id')
						->where('comic_types.type_id',$type_id);
		}
		$date_lists = $date_lists->select('comics.title as title','comics.slug as slug','comics.id as id','view_comics.view_date as view_date','view_comics.view_month as view_month','view_comics.view_all as view_all')
        			->orderBy('view_comics.view_date','desc')
        			->orderBy('view_comics.view_month','desc')
        			->orderBy('view_comics.view_all','desc')->paginate(10);
        $month_lists = ViewComic::join('comics','view_comics.comic_id','=','comics.id');
        if ($type_id != null) {
			$month_lists = $month_lists->join('comic_types','comics.id','=','comic_types.comic_id')
						->where('comic_types.type_id',$type_id);
		}
		$month_lists = $month_lists->select('comics.title as title','comics.slug as slug','comics.id as id','view_comics.view_month as view_month','view_comics.view_all as view_all')
        			->orderBy('view_comics.view_month','desc')
        			->orderBy('view_comics.view_all','desc')->paginate(10);			
        $lists = ViewComic::join('comics','view_comics.comic_id','=','comics.id');
        if ($type_id != null) {
			$lists = $lists->join('comic_types','comics.id','=','comic_types.comic_id')
						->where('comic_types.type_id',$type_id);
		}
		$lists = $lists->select('comics.title as title','comics.slug as slug','comics.id as id','view_comics.view_month as view_month','view_comics.view_all as view_all')
        			->orderBy('view_comics.view_month','desc')
        			->orderBy('view_comics.view_all','desc')->paginate(10);
		$data['type_id'] = $type_id;
		$data['date_lists'] = $date_lists;
		$data['month_lists'] = $month_lists;
		$data['lists'] = $lists;
		$html = view('sidebars.view_comic', $data)->render();
		return $html;
	}	

}
if(!function_exists('checkComicHot')){
	function checkComicHot($comic_id) {
		$catHotId = Metas::select('content')->where('id',13)->first();
        if ($catHotId != '') {
        	$check = ComicCat::select('id')->where('comic_id',$comic_id)
     			->where('cat_id',$catHotId->content)->first();
     		if ($check) { return true; }
     		else { return false; }     		
        }else{
        	return false;
        }    	  
	}
}
if(!function_exists('checkComicNew')){
	function checkComicNew($comic_id) {
		$catHotId = Metas::select('content')->where('id',19)->first();
        if ($catHotId != '') {
        	$check = ComicCat::select('id')->where('comic_id',$comic_id)
     			->where('cat_id',$catHotId->content)->first();
     		if ($check) { return true; }
     		else { return false; }     		
        }else{
        	return false;
        }    	  
	}
}
if(!function_exists('checkComicFull')){
	function checkComicFull($comic_id) {
		$catHotId = Metas::select('content')->where('id',20)->first();
        if ($catHotId != '') {
        	$check = ComicCat::select('id')->where('comic_id',$comic_id)
     			->where('cat_id',$catHotId->content)->first();
     		if ($check) { return true; }
     		else { return false; }     		
        }else{
        	return false;
        }    	  
	}
}
/**
* get author Artist
* @return array
*/
if(! function_exists('get_authorArtist')) {
    function get_authorArtist() {
        return array(
            '1'=>'Tác giả',
            '2'=>'Họa sĩ',
        );
    }
}
/**
* get status comic
* @return array
*/
if(! function_exists('get_statusComic')) {
    function get_statusComic() {
        return array(
            'pending'=>'pending',
            'public'=>'public',
            'draft'=>'draft',
            'hidden'=>'hidden',
        );
    }
}
/**
* get author status comic
* @return array
*/
if(! function_exists('authorStatusComic')) {
    function authorStatusComic() {
        return array(
            'Đã hoàn thành'=>'Đã hoàn thành',
            'Đang tiến hành'=>'Đang tiến hành',
            'Tạm dừng'=>'Tạm dừng',
            'Dừng vô thời hạn'=>'Dừng vô thời hạn',
        );
    }
}
/**
* get list comic by chap_id
*/
if(! function_exists('getListComicByChapId')) {
    function getListComicByChapId($chap_id) {
        return Comic::whereHas('books.chaps', function ($q) use ($chap_id){
		        $q->where('id', $chap_id);   
		    })->distinct()->first();
    }
}
/*
* get slug user in comic ST
* @param $comic_id
*/
if(! function_exists('getObjSlugTitleUserInComicST')){
	function getObjSlugTitleUserInComicST($user_id){
		$html = '';
		$user = User::where('id', $user_id)->select('id','slug','name')->first();	
		$html .= '<a href="'.route('comicWriter',$user->slug).'?type='."sang-tac".'">'.$user->show_name().'</a>';
		return $html;
	}
}
/*
* get point by month
*/
if(! function_exists('getPointByMonth')){
	function getPointByMonth($fromMonth, $toMonth){
		$start = date_create_from_format("Y-m-d",$fromMonth)->modify("first day of this month");
		$end = date_create_from_format("Y-m-d",$toMonth)->modify("first day of this month");
		$timespan = date_interval_create_from_date_string("1 month");
		$months = [];
		$years = [];
		while ($start <= $end) {
		    $months[] = $start->format("Y-m");
		    $start = $start->add($timespan);
		}
		return $months;
	}
}