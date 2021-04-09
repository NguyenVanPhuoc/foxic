<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Products;
use App\Seo;
use App\TypeComic;
use Validator;

class TypeComicAdminController extends Controller
{
	public function index(){
		$list_type = TypeComic::orderBy('position')->get();
		$data = [];
		$data['list_type'] = $list_type;
		return view('backend.typeComics.list', $data);
	}

	public function create(){
		return view('backend.typeComics.create');
	}

	public function store(Request $request){
		TypeComic::stripXSS();
		$list_rules = [];
        $list_rules['title'] = 'required|unique:type_comics';

		$validator = Validator::make($request->all(), $list_rules, TypeComic::getMessageRule());

		if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
		$request['position'] =  TypeComic::count();
        $request['slug'] = $request->title;

        //insert to DB
        $catComic = TypeComic::create($request->all());
        Seo::addNew($request->meta_key, $request->meta_value, $catComic->id, 'type_comic');

        return response()->json(['success' => 'Thêm thành công.', 'url' => route('createTypeComicAdmin')]);
	}

	public function edit($id){
		$typeComic = TypeComic::findOrFail($id);
		$data = [];
		$data['typeComic'] = $typeComic;
		return view('backend.typeComics.edit', $data);
	}

	public function update($id, Request $request){
		TypeComic::stripXSS();
		$typeComic = TypeComic::findOrFail($id);
		$list_rules = [];
		$list_rules['title'] = 'required';
		
		$validator = Validator::make($request->all(), $list_rules, $typeComic->getMessageRule());

		if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);

        $request['slug'] = str_slug($request->title, '-');
        //update seo
        Seo::updateSeo($request->meta_key, $request->meta_value, $id, 'type_comic');
		unset($request['_token']);
		unset($request['meta_key']);
		unset($request['meta_value']);

        //update to DB
        $typeComic->update($request->all());
        return response()->json(['success' => 'Cập nhật thành công.']);
	}

	public function delete($id){
		$seo = Seo::where('post_id',$id)->where('type','type_comic')->first();
        if($seo) $seo->delete();
        $item = TypeComic::findOrFail($id);
        $item->delete();
        return redirect()->route('typeComicsAdmin')->with('success','Xoá thành công');
	}

	public function position(Request $request){
		if($request->ajax()){
			$routes = json_decode($request->routes);
			$array_id = [];
			$array_position = [];
			foreach($routes as $item){
				TypeComic::where('id', $item->id)->update(['position' => $item->position]);
			}
			return 'success';
		}
		return 'error';
	}
}
