<?php
use App\TypeComic;

/**
* get list type comic
* @param false
* @return list type
*/
if (!function_exists('getListTypeComic')) {
    function getListTypeComic() {
        return TypeComic::select('title','slug')->orderBy('position')->get();
    }
}
