<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pages;

class PageController extends Controller
{
	//get new products
    public function getPage(Request $request, $id){    	
		if($request->key == tokenApi()):
			$result = Pages::where('id',$id)->select('title','content')->get();			
			return response()->json([
				'status'=> 200,				
				'data'=> $result,
				'msg'=>'OK'
			]);
		endif;
		return response()->json([
			'status'=> 405,
			'msg'=>'Method Not Allowed'
		]);    	
    } 	
}
