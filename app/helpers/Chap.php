<?php 
use App\Chap;
use App\Action;
use App\MediaComic;
use App\Media;
use Carbon\Carbon;

/*
* get slug by chap_id 
*/
if(! function_exists('getChapByID')){
	function getChapByID($chap_id){
		return Chap::where('id', $chap_id)->first();
	}
}
/*
* get next ep of comic 
* @param $commic_id
* @return number ep
*/
if(! function_exists('getNextEp')){
	function getNextEp($comic_id){
		$count_chap = Chap::where('comic_id', $comic_id)->where('type_title', 'number')->count();
		return $count_chap + 1;
	}
}

/*
* get type user of chap
* @param $chap_id
* @return text type user
*/
if(! function_exists('getTypeUserOfChap')){
	function getTypeUserOfChap($chap_id){
		$array_typeUser = config('data_config.chap_type_user');
		$chap = Chap::findOrFail($chap_id);
		$text = '';
		foreach($array_typeUser as $type){
			if($type['value'] == $chap->type_user){
				$text = $type['title'];
				break;
			}
		}
		return $text;
	}
}

/*
* get list old media of chap
* @param $chap_id, int $skip, int $limit
* @return list object media
*/
if(! function_exists('getListOldMediaOfChap')){
	function getListOldMediaOfChap($chap_id, $skip = false, $limit = false){
		$media_comicID = MediaComic::where('image_of', 'chap')->where('post_id', $chap_id)->pluck('media_id')->toArray();
		if($skip && $limit)
			$list_media = Media::whereIn('id', $media_comicID)->latest()->skip($skip)->limit($limit)->get(); 
		else
			$list_media = Media::whereIn('id', $media_comicID)->latest()->get(); 
		return $list_media;
	}
}

/*
* get number last chap by comic id
* @param $comic_id
* @return list object media
*/
if(! function_exists('getNumLastChapByComicId')){
	function getNumLastChapByComicId($comic_id){
		$num_last_chap = Chap::where('comic_id', $comic_id)->orderBy('position','desc')->pluck('position');
		if($num_last_chap->isNotEmpty()){
			if ($num_last_chap->count() == 1 ) {
				return $num_last_chap->count();
			}else{
				return $num_last_chap->first();
			}
		}else{
			return 0;
		}
		
	}
}
/*
* get latest chap by comic id
* @param $comic_id
* @return list object media
*/
if(! function_exists('getLatestChapByComicId')){
	function getLatestChapByComicId($comic_id){
		$comic_query = function ($query) use ($comic_id) {
            return $query->where('id',$comic_id);
        };
        $chap = Chap::with(['book.comic'=>$comic_query])
                    ->whereHas('book.comic', $comic_query)->orderBy('position','desc')->first();
		return $chap;
	}
}
/*
* check chap position is type user ?
* @param $position 
* return type user 
*/
if(! function_exists('checkTypeUserChapByPosition')){
	function checkTypeUserChapByPosition($position) {
		return $result = Chap::where('position',$position)->pluck('type_user')->first();
	}
}
/*
* check chap position exists
* @param $position
* return true or false
*/
if(! function_exists('checkChapByPosition')){
	function checkChapByPosition($position) {
		$result = Chap::where('position',$position)->first();
		if ($result != null) {
			return true;
		}else{
			return false;
		}
	}
}
/*
* Count chap of comic by comic_id
*/
if(!function_exists('countTotalChap')) {
	function countTotalChap($comic_id) {
		return Chap::select('id')->where('comic_id',$comic_id)->count();
	}
}

/*
* Get 5 chaps reading by $_COOKIE
*/
if(!function_exists('getReadingChaps')) {
	function getReadingChaps() {
		$reading = array();                
        if(isset($_COOKIE['chap_comic']) && $_COOKIE['chap_comic'] != '' ){
            $cookie = $_COOKIE['chap_comic'];
            $cookie = stripslashes($cookie);
            $zzz = json_decode($cookie, true);
            foreach ($zzz as $key=>$value) {
                if ($key<=4) {
                    $reading[] = Chap::join('comics','chaps.comic_id','=','comics.id')
                                ->where('chaps.id',$value['chap'])
                                ->select('chaps.short_chap as short_chap', 'chaps.slug as slug_chap', 'comics.title as comic_title', 'comics.slug as comic_slug')
                                ->first();
                }
            }            
        };
        return $reading;  
	}
}
/*
* Get Setting to header
*/
if(!function_exists('getSettingChap')) {
	function getSettingChap() {
		$headSet = array();                
        if(isset($_COOKIE['readingSetting']) && $_COOKIE['readingSetting'] != '' ){
            $cookie = $_COOKIE['readingSetting'];
            $cookie = stripslashes($cookie);
            $headSet = json_decode($cookie, true);            
        };
        return $headSet;  
	}
}


/*
* check rentchaps by chap_id & user_id
*/
if(!function_exists('checkRentChaps')) {
	function checkRentChaps($chap_id, $user_id) {
		$check = 0;
		$chap = Chap::where('id', $chap_id)->first();
		if(isset($chap) && $chap->rental == 0){
			$check = 1;
		}else{
			$check = 0;
			$rentchap = Action::where('chap_id', $chap_id)
							->where('user_id', $user_id)
							->where('type', 'rental')
							->latest()->first();
			if(isset($rentchap)){
				$check = 1;
				$mytime = Carbon::now()->format('Y-m-d H:i:s');
				$rental = $rentchap->rental_period;
				$date_time = strtotime($mytime) - strtotime($rental);
				if($date_time <= 48*3600) $check = 1;
				else $check = 0;
			}else{
				$check = 0;
			}
		}
	return $check;
	}
}
/*
* check buyChap by chap_id & user_id
*/
if(!function_exists('checkBuyChaps')) {
	function checkBuyChaps($chap_id, $user_id) {
		$buy = 0;
		$buychap = Action::where('chap_id', $chap_id)
							->where('user_id', $user_id)
							->where('type', 'buy')
							->first();
		if(isset($buychap)) $check = 1;
		else $check = 0;
	return $check;
	}
}