<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Seo;
use App\CategoryComic;
use Validator;

class CategoryComicAdminController extends Controller
{
	public function index(){
		$list_cat = CategoryComic::latest()->paginate(14);
		$data = [];
		$data ['list_cat'] = $list_cat;
		return view('backend.catComics.list', $data);
	}

	public function create(){
		return view('backend.catComics.create');
	}

	public function store(Request $request){
		CategoryComic::stripXSS();
		$list_rules = [];
        $list_rules['title'] = 'required';

		$validator = Validator::make($request->all(), $list_rules);

		if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);

        $request['slug'] = $request->title;
       

        //insert to DB
        $catComic = CategoryComic::create($request->only('title', 'desc', 'icon', 'image'));
        Seo::addNew($request->meta_key, $request->meta_value, $catComic->id, 'category_comic');

        return response()->json(['success' => 'Add to success.', 'url' => route('createCatComicAdmin')]);
	}

	public function edit($id){
		$catComic = CategoryComic::findOrFail($id);
		$data = [];
		$data['catComic'] = $catComic;
		return view('backend.catComics.edit', $data);
	}

	public function update($id, Request $request){
		CategoryComic::stripXSS();
		$list_rules = [];
        $list_rules['title'] = 'required';

		$validator = Validator::make($request->all(), $list_rules);

		if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);

        $request['slug'] = str_slug($request->title, '-');
        //update seo
        Seo::updateSeo($request->meta_key, $request->meta_value, $id, 'category_comic');
		unset($request['_token']);
		unset($request['meta_key']);
		unset($request['meta_value']);

        //update to DB
        $catComic = CategoryComic::where('id', $id)->update($request->only('title', 'desc', 'icon', 'image'));
        return response()->json(['success' => 'Update to success.']);

	}

	public function delete($id){
		$seo = Seo::where('post_id',$id)->where('type','category_comic')->first();
        if($seo) $seo->delete();
        $item = CategoryComic::findOrFail($id);
        $item->delete();
        return redirect()->route('catComicsAdmin')->with('success','Deleted Successful');
	}

	public function deleteAll(Request $request){
        if($request->ajax()){
            $items = json_decode($request->items);
            if(count($items)>0){
            	Seo::whereIn('post_id', $items)->where('type','category_comic')->delete();
                CategoryComic::destroy($items);
            }
            $list_cat = CategoryComic::latest()->paginate(14);
            $data = [];
            $data['list_cat'] = $list_cat;
            return response()->json(['msg' => 'success', 'html' => view('backend.catComics.table', $data)->render()]);
        }
        return response()->json(['msg' => 'error']);
	}
}