<?php
use App\Article;
use App\Category;
use App\Media;
use App\CategoryPayment;

/**
* generate status array
*/
if(!function_exists('generate_status')){
	function generate_status(){
		return [
			'draft' => 'Draft',
			'public' => 'Public',
			'trash' => 'Trash',
		];
	}
}

/**
* display status options
* @param $status
*/
if(!function_exists('display_status_option')){
	function display_status_option($status=null){
		$stt = generate_status();
		$html = '';
		if($stt):
			foreach ($stt as $key => $value) {
				$html .= '<option value="'.$key.'"'.($key == $status ? ' selected' : '').'>'.$value.'</option>';
			}
		endif;
		return $html;
	}
}

/**
* display category options
* @param $array
*/
if(!function_exists('display_categoies_option')){
	function display_categoies_option($array=array()){
		$cates = Category::select('id','title')->latest()->get();
		$html = '';
		if($cates):
			foreach ($cates as $cate) {
				$html .= '<option value="'.$cate->id.'"'.(in_array($cate->id,$array) ? ' selected' : '').'>'.$cate->title.'</option>';
			}
		endif;
		return $html;
	}
}
if (! function_exists('get_categories_article')) {
	function get_categories_article($id){        
		return Category::find($id);
	}
}
/*
* get list article in category id
* @param $cat_id
*/
if(!function_exists('getListArticleInCat')){
	function getListArticleInCat($cate_id){
		$article = Article::whereRaw('json_contains(cate_id, \'["' . $cate_id . '"]\')')
					->where('status','public')
					->select('articles.*')
					->distinct()
					->orderBy('created_at','desc')->paginate(14);
		return $article;
	}
}

if (! function_exists('get_categories_payment')) {
	function get_categories_payment($id){        
		return CategoryPayment::find($id);
	}
}