<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Seo;
use App\Category;
use App\Article;
use App\Media;
use Validator;

class ArticleAdminController extends Controller
{
	public function index(Request $request){
        $s = $request->s;
        if($s!=""):
            $articles = Article::where('title','like','%'.$s.'%')->latest()->paginate(14);
        else:
           $articles = Article::latest()->paginate(14);
        endif;
		$data = [];
		$data ['articles'] = $articles;
        $data ['s'] = $s;
		return view('backend.articles.list', $data);
	}

	public function create(){
		return view('backend.articles.create');
	}

	public function store(Request $request){
		$list_rules = [];
        $list_rules['title'] = 'required';
		$validator = Validator::make($request->all(), $list_rules);
		if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        $request['slug'] = $request->title;
        $article = new Article;
        $article->title = $request->title;
        $article->slug = $request->slug;
        $article->content = $request->content;
        $article->desc = $request->desc;
        $article->image = $request->image;
        $article->status = $request->status;
        $article->cate_id = $request->cate_id;
        $article->save();
        Seo::addNew($request->meta_key, $request->meta_value, $article->id, 'article');
        return response()->json(['success' => 'Create Complete', 'url' => route('createArticleAdmin')]);
	}

	public function edit($id){
		$article = Article::findOrFail($id);
		$cat = Category::findOrFail($article->cate_id);
		$data = [];
        $data['article'] = $article;
        $data['cat'] = $cat;
		return view('backend.articles.edit', $data );
		
	}

	public function update($id, Request $request){
        $article = Article::findOrFail($id);
        $list_rules = [];
        $list_rules['title'] = 'required';
        $validator = Validator::make($request->all(), $list_rules);
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        $request['slug'] = $request->title;
        $article->update($request->only('title', 'slug', 'desc', 'image', 'content', 'status', 'cate_id'));
        Seo::updateSeo($request->meta_key, $request->meta_value, $article->id, 'article');
       	unset($request['_token']);
		unset($request['meta_key']);
		unset($request['meta_value']);
        return response()->json(['success' => 'Update to success.', 'url' => route('editArticleAdmin', $id)]);
	}

	public function delete($id){
		$seo = Seo::where('post_id',$id)->where('type','article')->first();
        if($seo) $seo->delete();
        $item = Article::findOrFail($id);
        $item->delete();
        return redirect()->route('articlesAdmin')->with('success','Deleted Successful');
	}

	public function deleteAll(Request $request){
        if($request->ajax()){
            $items = json_decode($request->items);
            if(count($items)>0){
            	Seo::whereIn('post_id', $items)->where('type','article')->delete();
                Article::destroy($items);
            }
            $articles = Article::latest()->paginate(14);
            $data = [];
            $data['articles'] = $articles;
            return response()->json(['msg' => 'success', 'html' => view('backend.articles.table', $data)->render()]);
        }
        return response()->json(['msg' => 'error']);
	}

	
}