<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Products;
use App\Seo;
use App\Comic;
use App\Chap;
use App\Book;
use App\MediaComic;
use App\Media;

use Validator;

class BookAdminController extends Controller
{
    public function index($comic_id){
        $list_book = Book::where('comic_id', $comic_id)->orderBy('position')->get();
        $comic = Comic::findOrFail($comic_id);
        $data = [];
        $data['list_book'] = $list_book;
        $data['comic'] = $comic;
        
        return view('backend.books.list', $data);
    }

    public function create($comic_id){
        $comic = Comic::findOrFail($comic_id);
        $data = [];
        $data['comic'] = $comic;
        return view('backend.books.create', $data);
    }

    public function store($comic_id, Request $request){
        $list_rules = [];
        $list_rules['title'] = 'required';
        $request['slug'] = str_slug($request->title);
        $request['comic_id'] = $comic_id;
        $request['position'] =  Book::where('comic_id', $comic_id)->count();             
        $book = Book::create($request->only('title', 'slug', 'image', 'position', 'comic_id'));
        //Comic::where('id',$comic_id)->update($request->only('chap_up'));
        Seo::addNew($request->meta_key, $request->meta_value, $book->id, 'book');
        return response()->json(['success' => 'Thêm thành công.', 'url' => route('createBookAdmin', $comic_id)]);
    }
    public function edit($comic_id, $id){
        $comic = Comic::findOrFail($comic_id);
        $book = book::findOrFail($id);
        $data = [];
        $data['comic'] = $comic;
        $data['book'] = $book;
        return view('backend.books.edit', $data);
    }

    public function update($comic_id, $id, Request $request){
        $list_rules = [];
        $list_rules['title'] = 'required';
        $request['slug'] = str_slug($request->title);
        $book = Book::findOrFail($id);
        $book->update($request->only('title','slug','image'));
        //update seo
        Seo::updateSeo($request->meta_key, $request->meta_value, $id, 'book');
        return response()->json(['success' => 'Cập nhật thành công.']);
    }

    public function delete($comic_id, $id){
        $seo = Seo::where('post_id',$id)->where('type','chap')->delete();
        $item = Book::findOrFail($id);
        $item->delete();
        return redirect()->route('booksAdmin', $comic_id)->with('success','Xoá thành công.');
    }

    public function loadTitle($comic_id, Request $request){
        if($request->ajax()){
            $typeTitle = $request->value;
            $title = '';
            if($typeTitle == 'number')
                $title = getNextEp($comic_id);
            elseif($typeTitle == 'prologue')
                $title = 'Prologue';
            return $title;
        }
    }
    
    //position
    public function postion($comic_id, Request $request){
        if($request->ajax()){
            $routes = json_decode($request->routes);
            $array_id = [];
            $array_position = [];
            foreach($routes as $item){
                Book::where('id', $item->id)->update(['position' => $item->position]);
            }
            return 'success';
        }
        return 'error';
    }
}