<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Products;

class ProductSearchController extends Controller
{	
 	public function index(Request $request, $key, $start, $number){    	
		if($request->key == tokenApi()):
			$total = products::where('title','LIKE','%'.$key.'%')->count();			
			$products = Products::leftJoin('media','products.image','=','media.id')
			->where('products.title','LIKE','%'.$key.'%')
			->select('products.id as id','products.title as title','price','price_sale','image_path as image')
			->skip($start)->take($number)->orderBy('products.created_at','dsc')->get();			
			return response()->json([
				'status'=> 200,				
				'data'=> $products,
				'msg'=>'OK',
				'total'=>$total
			]);
		endif;
		return response()->json([
			'status'=> 405,
			'msg'=>'Method Not Allowed'
		]);    	
    }
}
