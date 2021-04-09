<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Options;

class SystemController extends Controller
{
    public function getLogo(Request $request){
        if($request->key == tokenApi()):
            $result = Options::leftJoin('media','media.id','=','options.logo')
            ->select('image_path as logo')->get(); 
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
    public function getContact(Request $request){
        if($request->key == tokenApi()):
            $result = Options::select('phone','email','mobiAddress','lag','log','website')->get(); 
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