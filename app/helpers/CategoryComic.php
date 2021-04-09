<?php
use App\CategoryComic;

/**
* get category by id
* @param $id
* @return category detail
*/
if(!function_exists('getCatComic')){
    function getCatComic($id){
        return CategoryComic::find($id);
         
    }
}
/**
* get list category comic
* @param false
* @return list category
*/
if (!function_exists('getListCatComic')) {
    function getListCatComic() {
        return CategoryComic::select('title','slug')->orderBy('title','desc')->get();
    }
}