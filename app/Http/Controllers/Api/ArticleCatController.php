<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ArticleCat;
use App\Article;

class ArticleCatController extends Controller
{	
    public function index(Request $request){    	
		if($request->key == tokenApi()):
			$result = ArticleCat::where('parent_id','0')->select('title','id')->latest()->get();			
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
 	public function getCat(Request $request, $id, $page){    	
		if($request->key == tokenApi()):			
			$total = Article::where('cat_id',$id)->count();
			$start = 0;
			$items = 4;			
			$totalPage = ((int)ceil($total/$items)) -1 ;
			if($page <= $totalPage){
				if($page>0){
					$start = $page * $items;
				}				
				$result = Article::leftJoin('media','articles.image','=','media.id')
				->where('articles.cat_id',$id)
				->select('articles.id as id','articles.title as title','image_path as image','articles.desc as desc','view')
				->skip($start)->take($items)->orderBy('articles.created_at','dsc')->get();		
				return response()->json([
					'status'=> 200,				
					'data'=> $result,
					'msg'=>'OK',
					'total'=> $total,
					'totalPage'=> $totalPage
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
