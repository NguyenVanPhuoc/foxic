<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;

class ArticleController extends Controller
{
    public function getNews(Request $request, $page){
    	if($request->key == tokenApi()):
    		$total = Article::count();
			$start = 0;
			$items = 4;			
			$totalPage = ((int)ceil($total/$items)) -1 ;
			if($page <= $totalPage){
				if($page>0){
					$start = $page * $items;
				}
				$result = Article::leftJoin('media','products.image','=','media.id')
				->select('articles.id as id','articles.title as title','articles.desc as desc','image_path as image','view')
				->skip($start)->take($items)->orderBy('articles.created_at','dsc')->get();			
				return response()->json([
					'status'=> 200,
					'data'=> $result,
					'msg'=>'OK'
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
    public function getDetail(Request $request, $id){
		if($request->key == tokenApi()):
			$result = Article::leftJoin('media','articles.image','=','media.id')
			->select('articles.id as id','articles.title as title','articles.content as content', 'cat_id','image_path as image')
			->where('articles.id',$id)
			->get();			
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

    public function getRelated(Request $request, $id, $catId, $page){
		if($request->key == tokenApi()):					
			$total = Article::where('cat_id',$catId)->where('id','<>',$id)->count();
			$start = 0;
			$items = 4;			
			$totalPage = ((int)ceil($total/$items)) -1 ;
			if($page <= $totalPage){
				if($page>0){
					$start = $page * $items;
				}
				$result = Article::leftJoin('media','articles.image','=','media.id')
				->select('articles.id as id','articles.title as title','articles.desc as desc','cat_id','image_path as image','view')
				->where('articles.id','<>',$id)
				->where('cat_id', $catId)
				->skip($start)->take($items)->orderBy('articles.created_at','dsc')->get();
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
    public function setView(Request $request, $id){
		if($request->key == tokenApi()):
			$result = set_view($id);
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
