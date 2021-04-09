<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SlideDetail;
use App\CategoryProducts;
use App\Products;

class SlideController extends Controller
{	
    public function index(Request $request, $id){
		if($request->key == tokenApi()):
			$result = SlideDetail::leftJoin('media','media.id','=','slide_details.image')->where('slide_details.slide_id',$id)
			->select('image_path as image')->orderBy('slide_details.position','dsc')->get();			
			if(count($result)>0){
				return response()->json([
					'status'=> 200,				
					'data'=> $result,
					'msg'=>'OK'
				]);	
			}else{
				return response()->json([
					'status'=> 404,
					'data'=> $result,
					'msg'=>'No result'
				]);
			}
			
		endif;
		return response()->json([
			'status'=> 405,
			'msg'=>'Method Not Allowed'
		]);    	
    }    
}
