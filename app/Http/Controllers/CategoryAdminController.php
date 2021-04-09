<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Seo;
use App\Category;
use Validator;

class CategoryAdminController extends Controller
{
	public function index(){
		$cates = Category::latest()->paginate(14);
		$data = [];
		$data ['cates'] = $cates;
		return view('backend.categories.list', $data);
	}

	public function create(){
		return view('backend.categories.create');
	}

	public function store(Request $request){
		$list_rules = [];
        $list_rules['title'] = 'required';
		$validator = Validator::make($request->all(), $list_rules);
		if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);

        $request['slug'] = $request->title;
        $cate = Category::create($request->only('title', 'content', 'image', 'slug'));
        Seo::addNew($request->meta_key, $request->meta_value, $cate->id, 'category');
        return response()->json(['success' => 'Create Complete', 'url' => route('createCategoryAdmin')]);
	}

	public function edit($id){
		$cate = Category::findOrFail($id);
		$data = [];
		$data['cate'] = $cate;
		return view('backend.categories.edit', $data);
	}

	public function update($id, Request $request){
		$list_rules = [];
        $list_rules['title'] = 'required';
		$validator = Validator::make($request->all(), $list_rules);
		if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all()]);
        $request['slug'] = $request->title;
        Seo::updateSeo($request->meta_key, $request->meta_value, $id, 'category');
		unset($request['_token']);
		unset($request['meta_key']);
		unset($request['meta_value']);
        $cate = Category::where('id', $id)->update($request->only('title', 'slug', 'content', 'image'));
        return response()->json(['success' => 'Update complete.']);

	}

	public function delete($id){
		$seo = Seo::where('post_id',$id)->where('type','category')->first();
        if($seo) $seo->delete();
        $item = Category::findOrFail($id);
        $item->delete();
        return redirect()->route('categoriesAdmin')->with('success','Deleted Successful');
	}

	public function deleteAll(Request $request){
        if($request->ajax()){
            $items = json_decode($request->items);
            if(count($items)>0){
            	Seo::whereIn('post_id', $items)->where('type','category')->delete();
                Category::destroy($items);
            }
            $cates = Category::latest()->paginate(14);
            $data = [];
            $data['cates'] = $cates;
            return response()->json(['msg' => 'success', 'html' => view('backend.categories.table', $data)->render()]);
        }
        return response()->json(['msg' => 'error']);
	}
}