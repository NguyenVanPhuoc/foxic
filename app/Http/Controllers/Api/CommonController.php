<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{   
    //get image url    
    public function getImgUrl(Request $request, $id){
		if($request->key == tokenApi()):			
			return response()->json([
				'status'=> 200,
				'data'=> getImgUrl($id),
				'msg'=>'OK'
			]);
		endif;
		return response()->json([
			'status'=> 405,
			'msg'=>'Method Not Allowed'
		]); 
    }
}
