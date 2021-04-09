<?php
use App\Notice;
use App\User;
use Carbon\Carbon;

/*
* get notice by id
* @param $id
*/
if(!function_exists('getNoticeById')){
	function getNoticeById($id){
		return Notice::where('id', $id)->first(); 
	}
}
/*
* hide tick reading chap notification
*/
if(!function_exists('readingNotification')) {
	function readingNotification($id, $user_id) {
		$notice= \DB::table('notifications')
		->where('notifiable_id',$user_id)
		->where('type','App\Notifications\DataNotifications')
		->where('data->id',$id)->update(['read_at' => Carbon::now()]);
		if ($notice) {
			return true;
		}else{
			return false;
		}
	}
}
/*
* get list notification by user_id
*/
if(!function_exists('getListNoticeByUserId')) {
	function getListNoticeByUserId($user_id) {
		$notice= \DB::table('notifications')
		->where('notifiable_id',$user_id)
		->where('type','App\Notifications\DataNotifications')
		->paginate(9);
		return $notice;
	}
}
/**
* select user to receive the notification
* @return array
*/
if(! function_exists('selectUserToTheNotification')) {
    function selectUserToTheNotification() {
        return array(
            '1'=>'Tất cả',
            '2'=>'Thành viên hiện tại',
            '3'=>'Thành viên mới',
        );
    }
}