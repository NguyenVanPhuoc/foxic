<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Products;

class ProductController extends Controller
{
	//get new products
    public function newProduts(Request $request, $start, $number){    	
		if($request->key == tokenApi()):
			$products = Products::leftJoin('media','products.image','=','media.id')
			->select('products.id as id','products.title as title','price','price_sale','image_path as image')
			->skip($start)->take($number)->orderBy('products.created_at','dsc')->get();			
			return response()->json([
				'status'=> 200,				
				'data'=> $products,
				'msg'=>'OK'
			]);
		endif;
		return response()->json([
			'status'=> 405,
			'msg'=>'Method Not Allowed'
		]);    	
    }

    public function getProdutDetail(Request $request, $id){
		if($request->key == tokenApi()):
			$product = Products::leftJoin('media','products.image','=','media.id')
			->select('products.id as id','products.title as title','price','price_sale','products.content as content', 'cat_id','image_path as image')
			->where('products.id',$id)
			->get();			
			return response()->json([
				'status'=> 200,				
				'data'=> $product,								
				'msg'=>'OK'
			]);
		endif;
		return response()->json([
			'status'=> 405,
			'msg'=>'Method Not Allowed'
		]);
    }

    public function getRelatedProducts(Request $request, $id, $catId, $page){
		if($request->key == tokenApi()):
			$total = products::where('cat_id',$catId)->where('id','<>',$id)->count();			
			$start = 0;
			$items = 4;
			$totalPage = ((int)ceil($total/$items)) -1 ;
			if($page <= $totalPage){
				if($page>0){
					$start = $page * $items;
				}
				$result = Products::leftJoin('media','products.image','=','media.id')
				->select('products.id as id','products.title as title','price','price_sale', 'cat_id','image_path as image')
				->where('products.id','<>',$id)
				->where('cat_id', $catId)
				->skip($start)->take($items)->orderBy('products.created_at','dsc')->get();
				return response()->json([
					'status'=> 200,				
					'data'=> $result,
					'msg'=>'OK',
					'total'=> $total
				]);
			}else{
				return response()->json([
					'status'=> 404,
					'msg'=>'Method not found'
				]);
			}
		endif;
		return response()->json([
			'status'=> 405,
			'msg'=>'Method Not Allowed'
		]);    	
    }
}
