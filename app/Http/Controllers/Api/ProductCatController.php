<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CategoryProducts;
use App\Products;
use App\Metas;

class ProductCatController extends Controller
{	
    public function getCollections(Request $request){    	
		if($request->key == tokenApi()):
			$result = CategoryProducts::leftJoin('media','media.id','=','category_products.image')->where('parent_id','0')
			->select('category_products.title as title','category_products.id as id','image_path as image')->orderBy('category_products.created_at','dsc')->get();			
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
    public function getParentCats(Request $request){    	
		if($request->key == tokenApi()):
			$result = CategoryProducts::where('parent_id','0')->select('title','id')->latest()->get();			
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
    public function getSubCats(Request $request, $id){    	
		if($request->key == tokenApi()):
			$result = CategoryProducts::where('parent_id',$id)->select('title','id')->latest()->get();			
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
	//get new products
    public function getProCats(Request $request){    	
		if($request->key == tokenApi()):
			$result = CategoryProducts::select('title','id')->latest()->get();			
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
 	public function getProCat(Request $request, $id, $page){    	
		if($request->key == tokenApi()):
			$total = products::where('cat_id',$id)->count();
			$start = 0;
			$items = 4;			
			$totalPage = ((int)ceil($total/$items)) -1 ;
			if($page <= $totalPage){
				if($page>0){
					$start = $page * $items;
				}
				$result = products::join('category_products','category_products.id','=','products.cat_id')
				->leftJoin('media','products.image','=','media.id')
				->where('category_products.id',$id)
				->select('products.id as id','products.title as title','price','price_sale','image_path as image')
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
    public function getTitleProCat(Request $request, $id){    	
		if($request->key == tokenApi()):			
			$result = CategoryProducts::where('id',$id)->select('id','title')->first();
			if(count($result)>0){
				return response()->json([
					'status'=> 200,				
					'data'=> $result,
					'msg'=>'OK'					
				]);
			}else{
				return response()->json([
					'status'=> 400,				
					'data'=> $result,
					'msg'=>'Method not found'
				]);
			}
		endif;
		return response()->json([
			'status'=> 405,
			'msg'=>'Method Not Allowed'
		]);    	
    }
    //get categories choose
    public function getCatsShoose(Request $request){    	
		if($request->key == tokenApi()):
			$result = Metas::find(4)->content;
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
