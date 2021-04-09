<?php 
namespace App\Providers;
use App\Options;

class Helper
{
    public static function logo($w, $h)
    {
    	$option = Options::find(1);
    	if($option->logo!=null) $logo = '<img src="/image/'.$option->logo.'/'.$w.'/'.$h.'" alt="'.$option->title.'"/>';
        else $logo = $option->title;
    	return $logo;
    	$src = $option->logo;
    	/*$caheimage = Image::cache(function($image) use ($src, $w, $h){
			return $image->make('public/uploads/'.$src)->resize($w, $h);
		}, 10, true);
		$extention = explode(".", $src);
		return $caheimage->response($extention[1]);*/
    }    
}