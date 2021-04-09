<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Products;
use App\Seo;
use App\Comic;
use App\Chap;
use App\Book;
use App\MediaComic;
use App\Media;
use Validator;
class ChapAdminController extends Controller
{
	public function index($comic_id, $book_id){
		$list_chap = Chap::where('book_id', $book_id)->orderBy('position')->get();
		$book = Book::findOrFail($book_id);
		$comic = Comic::findOrFail($comic_id);
		$data = [];
		$data['list_chap'] = $list_chap;
		$data['book'] = $book;
		$data['comic'] = $comic;
		return view('backend.chaps.list', $data);
	}
	public function create($comic_id, $book_id){
		$book = Book::findOrFail($book_id);
		$comic = Comic::findOrFail($comic_id);
		$data = [];
		$data['book'] = $book;
		$data['comic'] = $comic;
		return view('backend.chaps.create', $data);
	}
	public function store($comic_id, $book_id, Request $request){
		Chap::stripXSS();
		$list_rules = [];
       /* $list_rules['chap'] = 'required|unique:chaps';
        $list_rules['short_chap'] = 'required|unique:chaps';*/
		$list_rules['chap'] = 'required';
        $list_rules['short_chap'] = 'required';
		$list_rules['content'] = 'required';
		$validator = Validator::make($request->all(), $list_rules, Chap::getMessageRule());
		if($validator->fails()) return response()->json([ 'error' => $validator->errors()->all() ]);
		$str = Str::random(6);
		if($request->title){
			$request['slug'] = str_slug($str.'-'.$request->chap.'-'.$request->title,'-' );
		}else{
			$request['slug'] = str_slug($str.'-'.$request->chap.'');
		}
		$check = Chap::where('book_id',$book_id)->where('slug',$request['slug'])->first();
		if ($check != null) {
			return response()->json([ 'error' => [$str.'-'.$request->chap.'-'.$request->title,'-'.' đã tồn tại!'] ]);
		}
		$request['book_id'] = $book_id;
		$request['position'] =  Chap::where('book_id', $book_id)->count();		
		$request['chap_up'] = date('Y-m-d H:i:s');	
		$request['rental'] = $request->rental ? $request->rental : 0;
		$request['point'] = $request->point ? $request->point : 0;	
		$request['status'] = 'pending';
		$chap = Chap::create($request->only('chap', 'slug', 'short_chap', 'title', 'content', 'position', 'book_id', 'rental','point', 'status'));
		Comic::where('id',$comic_id)->update($request->only('chap_up'));
		Seo::addNew($request->meta_key, $request->meta_value, $chap->id, 'chap');
		return response()->json(['success' => 'Thêm thành công.', 'url' => route('createChapAdmin',['comic_id'=>$comic_id,'book_id'=>$book_id])]);
	}
	public function edit($comic_id, $book_id, $id){
		$comic = Comic::findOrFail($comic_id);
		$book = Book::findOrFail($book_id);
		$chap = Chap::findOrFail($id);
		$data = [];
		$data['comic'] = $comic;
		$data['book'] = $book;
		$data['chap'] = $chap;
		return view('backend.chaps.edit', $data);
	}
	public function update($comic_id, $book_id, $id, Request $request){
		Chap::stripXSS();
		$list_rules = [];
		$list_rules['content'] = 'required';
		$chap = Chap::findOrFail($id);
		$validator = Validator::make($request->all(), $list_rules, $chap->getMessageRule());
		if($validator->fails()) return response()->json([ 'error' => $validator->errors()->all() ]);
		$chap->update($request->only('title','content','rental','point', 'status'));
		//update seo
		Seo::updateSeo($request->meta_key, $request->meta_value, $id, 'chap');
		return response()->json(['success' => 'Cập nhật thành công.']);
	}
	public function delete($comic_id, $book_id, $id){
		$seo = Seo::where('post_id',$id)->where('type','chap')->delete();
        $item = Chap::findOrFail($id);
        $item->delete();
        return redirect()->route('chapsAdmin',['comic_id'=>$comic_id,'book_id'=>$book_id])->with('success','Xoá thành công.');
	}
	public function loadTitle($comic_id, $book_id, Request $request){
		if($request->ajax()){
			$typeTitle = $request->value;
			$title = '';
			if($typeTitle == 'number')
				$title = getNextEp($book_id);
			elseif($typeTitle == 'prologue')
				$title = 'Prologue';
			return $title;
		}
	}
	//position
	public function postion($comic_id, $book_id, Request $request){
		if($request->ajax()){
			$routes = json_decode($request->routes);
			$array_id = [];
			$array_position = [];
			foreach($routes as $item){
				Chap::where('id', $item->id)->update(['position' => $item->position]);
			}
			return 'success';
		}
		return 'error';
	}
}