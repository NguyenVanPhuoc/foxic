<?php
use App\Payment;
use App\CategoryPayment;


/*
* get list payment in pay_id
*/
if(!function_exists('getListPaymentInPayid')){
	function getListPaymentInPayid($pay_id){
		return $list_pay = Payment::with('catPayment')->where('pay_id',$pay_id)->where('package',2)->get();
	}
}
if(!function_exists('getListPaymentInPayidV1')){
	function getListPaymentInPayidV1($pay_id){
		return $list_pay = Payment::with('catPayment')->where('pay_id',$pay_id)->where('package',1)->get();
	}
}
/**
* get package
* @return array
*/
if(! function_exists('get_package')) {
    function get_package() {
        return array(
            '1'=>'Gói cơ bản',
            '2'=>'Gói khuyến mãi',
        );
    }
}