<?php
use App\Level;
use App\User;
//check login 
if(!function_exists('checkLogin')){
	function checkLogin(){
		return Auth::check();
	}
}

//get current user
if(!function_exists('getCurrentUser')){
	function getCurrentUser(){
		if(Auth::check()){
			$user = Auth::User();
			return $user;
		}
		return;
	}
}

//get level by user
if(!function_exists('getLevelByUser')){
	function getLevelByUser($user_id){
		$level = Level::where('id', $user_id)->select('title')->first();
		return $level->title;
	}
}

//get name by user
if(!function_exists('getNameByUser')){
    function getNameByUser($user_id){
        $name = User::where('id', $user_id)->select('name', 'point')->first();
        return $name;
    }
}
/**
* check current user is editor
* @return array
*/
if(! function_exists('check_editor')) {
    function check_editor() {
        $user = Auth::User();
        if($user->hasRole('Tác giả')) return true;
            else return false;
    }
}
/**
* get type author
* @return array
*/
if(! function_exists('getTypeAuthor')) {
    function getTypeAuthor() {
        return array(
            'official'=>'Chính thức',
            'unofficial'=>'Không chính thức',
            'unrestrained'=>'Tự do',
        );
    }
}
/**
* get status withdrawals
* @return array
*/
if(! function_exists('getStatusWithdrawals')) {
    function getStatusWithdrawals() {
        return array(
            'pending'=>'Đang xử lý',
            'completed'=>'Hoàn thành',
            'cancelled'=>'Hủy bỏ',
        );
    }
}
