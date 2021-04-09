<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Products;
use App\Seo;
use App\Comic;
use App\CategoryComic;
use App\TypeComic;
use App\Writer;
use App\Artist;
use App\ComicCat;
use App\ComicType;
use App\ComicWriter;
use App\ComicArtist;
use App\MediaComic;
use App\Media;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Notifications\SendMailComicPublic;
use Carbon\Carbon;
use Mail;

class ComicAdminController extends Controller
{
	public function index(Request $request){
        $user = Auth::user();
        $user_id= $user->id;
        if($request->ajax()){
            $page = 1;  $per_page = 14;
            $comics = Comic::query();                  
            if(isset($request->s) && $request->s != '')
                $comics = $comics->where('comics.title', 'like', '%'. $request->s .'%');
            if(isset($request->cat_id) && $request->cat_id != '')
                $comics = $comics->join('comic_cats', 'comics.id', '=', 'comic_cats.comic_id')->where('comic_cats.cat_id', $request->cat_id);
            if(isset($request->type_id) && $request->type_id != '')
                $comics = $comics->join('comic_types', 'comics.id', '=', 'comic_types.comic_id')->where('comic_types.type_id', $request->type_id);
            if(isset($request->artist_id) && $request->artist_id != '')
                $comics = $comics->join('comic_artists', 'comics.id', '=', 'comic_artists.comic_id')->where('comic_artists.artist_id', $request->artist_id);
            if(isset($request->writer_id) && $request->writer_id != '')
                $comics = $comics->join('comic_writers', 'comics.id', '=', 'comic_writers.comic_id')->where('comic_writers.writer_id', $request->writer_id);
            if(check_editor())
                $comics = $comics->where('comics.user_id', $user_id);
            $comics = $comics->distinct()->select('comics.*')->orderBy('comics.chap_up','desc')->get();
            $comicCollections = $comics instanceof Collection ? $comics : Collection::make($users); 
            if(isset($request->page) && $request->page != '')
                $page = $request->page; 
            $list_comic = new LengthAwarePaginator($comicCollections->forPage($page, $per_page), count($comicCollections), $per_page, $page);

            $data = [];
            $data ['list_comic'] = $list_comic;
            $html = view('backend.comics.table', $data)->render();
            return response()->json(['html' => $html]);
        }else{
            if(check_editor()) {
                $list_comic = Comic::where('comics.user_id', $user_id)->orderBy('comics.chap_up','desc')->paginate(14); 
                $list_writer = Writer::where('user_id', $user_id)->orderBy('title')->select('id', 'title')->get();
                $list_artist = Artist::where('user_id', $user_id)->orderBy('title')->select('id', 'title')->get();
            }else{
                $list_comic = Comic::orderBy('chap_up','desc')->paginate(14);
                $list_writer = Writer::orderBy('title')->select('id', 'title')->get();
                $list_artist = Artist::orderBy('title')->select('id', 'title')->get(); 
            }
            $list_cat = CategoryComic::orderBy('title')->select('id', 'title')->get();
            $list_type = TypeComic::orderBy('title')->select('id', 'title')->get();
            $data = [];
            $data ['list_comic'] = $list_comic;
            $data['list_cat'] = $list_cat;
            $data['list_type'] = $list_type;
            $data['list_writer'] = $list_writer;
            $data['list_artist'] = $list_artist;
            return view('backend.comics.list', $data);
        }
	}

	public function create(){
		$list_typeplus = config('data_config.type_plus_comic'); 
		$list_cat = CategoryComic::orderBy('title')->get();
		$list_type = TypeComic::orderBy('title')->get();
        if(check_editor()) {
                $list_writer = Writer::where('user_id', Auth::id())->orderBy('title')->get();
                $list_artist = Artist::where('user_id', Auth::id())->orderBy('title')->get();
        }else{
            $list_writer = Writer::orderBy('title')->get();
            $list_artist = Artist::orderBy('title')->get();
        }
		$data = [];
		$data['list_cat'] = $list_cat;
		$data['list_type'] = $list_type;
		$data['list_writer'] = $list_writer;
        $data['list_artist'] = $list_artist;
		return view('backend.comics.create', $data);
	}

	public function store(Request $request){
        Comic::stripXSS();
		$list_rules = [];
        $list_rules['title'] = 'required|unique:comics';
        $list_rules['desc'] = 'required';
        $list_rules['type'] = 'required';
        //$list_rules['writer'] = 'required';
        $validator = Validator::make($request->all(), $list_rules, Comic::getMessageRule());
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        $request['slug'] = $request->title;
        $request['image'] = isset($request->image) && $request->image != '' ? $request->image : null;
        $request['chap_up'] = Carbon::now();
        $list_catID = $request->categories;
        $list_typeID = $request->type;
        $list_writerID = $request->writer;
        $list_artistID = $request->artist;
        $request['user_id'] = Auth::id();
        $request['status'] = 'pending';
        $comic = Comic::create($request->only('title', /*'title_original',*/ 'slug', 'desc', 'excerpt', 'source', /*'end',*/ 'image', 'chap_up', 'au_status', 'status','user_id','mature'));
        Seo::addNew($request->meta_key, $request->meta_value, $comic->id, 'comic');
        if($list_catID){
            foreach($list_catID as $cat_id){
            	ComicCat::create([
                    'comic_id' => $comic->id,
                    'cat_id' => $cat_id
                ]);
            }
        }

        if($list_typeID ){
            foreach($list_typeID as $type_id){
            	ComicType::create([
                    'comic_id' => $comic->id,
                    'type_id' => $type_id
                ]);
            }
        }

        if($list_writerID){
            foreach($list_writerID as $writer_id){
            	ComicWriter::create([
                    'comic_id' => $comic->id,
                    'writer_id' => $writer_id
                ]);
            }
        }
        if($list_artistID){
            foreach($list_artistID as $artist_id){
                ComicArtist::create([
                    'comic_id' => $comic->id,
                    'artist_id' => $artist_id
                ]);
            }
        }

        //Update comic type is of comic
        $array_mediaID = [];
        if($request->image && $request->image != '') $array_mediaID[] = $request->image;
        if($request->book && $request->book != '') $array_mediaID[] = $request->book;
        Media::whereIn('id', $array_mediaID)->update(['image_of' => 'comic']);
        foreach($array_mediaID as $media_id){
            MediaComic::create(['post_id' => $comic->id, 'media_id' => $media_id, 'image_of' => 'comic']);
        }
        return response()->json(['success' => 'Thêm thành công.', 'url' => route('storeComicAdmin')]);
	}

	public function edit($id){
        $user = Auth::user();
		$comic = Comic::findOrFail($id);
        if($comic->user_id == $user->id || $user->hasPermissionTo('comics.edit_user')){
    		$list_cat = CategoryComic::orderBy('title')->get();
    		$list_type = TypeComic::orderBy('title')->get();
            if(check_editor()) {
                $list_writer = Writer::where('user_id', Auth::id())->orderBy('title')->get();
                $list_artist = Artist::where('user_id', Auth::id())->orderBy('title')->get();
            }else{
                $list_writer = Writer::orderBy('title')->get();
                $list_artist = Artist::orderBy('title')->get();
            }
    		$array_catID = ComicCat::where('comic_id', $id)->pluck('cat_id')->toArray();
    		$array_typeID = ComicType::where('comic_id', $id)->pluck('type_id')->toArray();
    		$array_writerID = ComicWriter::where('comic_id', $id)->pluck('writer_id')->toArray();
            $array_artistID = ComicArtist::where('comic_id', $id)->pluck('artist_id')->toArray();
            //dd($list_artist);
    		$data = [];
    		$data['comic'] = $comic;
    		$data['list_cat'] = $list_cat;
    		$data['list_type'] = $list_type;
    		$data['list_writer'] = $list_writer;
            $data['list_artist'] = $list_artist;
    		$data['array_catID'] = $array_catID;
    		$data['array_typeID'] = $array_typeID;
    		$data['array_writerID'] = $array_writerID;
            $data['array_artistID'] = $array_artistID;
    		return view('backend.comics.edit', $data);
        }else{
            return view('errors.403');
        }
	}

	public function update($id, Request $request){
        Comic::stripXSS();
		$comic = Comic::findOrFail($id);
		$array_catID = ComicCat::where('comic_id', $id)->pluck('cat_id')->toArray();
		$array_typeID = ComicType::where('comic_id', $id)->pluck('type_id')->toArray();
		$array_writerID = ComicWriter::where('comic_id', $id)->pluck('writer_id')->toArray();
        $array_artistID = ComicArtist::where('comic_id', $id)->pluck('artist_id')->toArray();

		$list_rules = [];
        $list_rules['title'] = 'required';
        $list_rules['desc'] = 'required';
        $list_rules['type'] = 'required';
        //$list_rules['writer'] = 'required';

		$validator = Validator::make($request->all(), $list_rules, $comic->getMessageRule());

		if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);

        $request['slug'] = str_slug($request->title, '-');
        $request['image'] = isset($request->image) && $request->image != '' ? $request->image : null;
        if($request->end == '') $request['end'] = 0;
        $comic->update($request->only('title','slug', 'desc', 'excerpt', 'source', 'au_status', 'image', 'mature', 'status'));
        if($comic->wasChanged('status')){
            if($request->status == 'public'){
                $users= User::where('id',$comic->user_id)->first();
                $users->notify(new SendMailComicPublic($comic));
            }
            if($request->status == 'hidden'){
                $user = Auth::user();
                $content = '';
                $content .='<div> Truyện không hợp lệ !!!';
                $content .='<a href="'.route('editComicAdmin', $comic->id).'">Link truyện</a>';
                $content .='</div>';
                $data = array( 'email' => 'vanphuoc260797@gmail.com', 'from' => $user->email, 'content' => $content);
                Mail::send( 'mails.hidden_comic', compact('data'), function( $message ) use ($data){
                    $message->to($data['email'])
                            ->from( $data['from'], '[Foxic]')
                            ->subject('[Truyện không hợp lệ]');
                });
            }
        }
        Seo::updateSeo($request->meta_key, $request->meta_value, $id, 'comic');
        $list_catID = $request->categories; //array
        $list_typeID = $request->type; //array
        $list_writerID = $request->writer; //array
        $list_artistID = $request->artist; //array

        /*cat*/
        //each list new chose ID, if id in list no exist in list old chose -> create
        if($list_catID){
            foreach($list_catID as $cat_id){
            	if(!in_array($cat_id, $array_catID)){
            		ComicCat::create(['comic_id' => $id, 'cat_id' => $cat_id]);
            	}
            }
        }
        //each list old chose ID, if id in list no exist in list new chose -> delete
        foreach($array_catID as $cat_id){
        	if(!in_array($cat_id, $list_catID)){
        		ComicCat::where('comic_id', $id)->where('cat_id', $cat_id)->delete();
        	}
        }

        /*type*/
        //each list new chose ID, if id in list no exist in list old chose -> create
        if($list_typeID){
            foreach($list_typeID as $type_id){
            	if(!in_array($type_id, $array_typeID)){
            		ComicType::create(['comic_id' => $id, 'type_id' => $type_id]);
            	}
            }
        }
        //each list old chose ID, if id in list no exist in list new chose -> delete
        foreach($array_typeID as $type_id){
        	if(!in_array($type_id, $list_typeID)){
        		ComicType::where('comic_id', $id)->where('type_id', $type_id)->delete();
        	}
        }


        /*writer*/
        //each list new chose ID, if id in list no exist in list old chose -> create
        //dd($list_writerID,$array_writerID);
        if(isset($list_writerID)){
            foreach($list_writerID as $writer_id){
            	if(!in_array($writer_id, $array_writerID)){
            		ComicWriter::create(['comic_id' => $id, 'writer_id' => $writer_id]);
            	}
            }
        }
        //each list old chose ID, if id in list no exist in list new chose -> delete
        if(isset($array_writerID) && $list_writerID != null){
            foreach($array_writerID as $writer_id){
            	if(!in_array($writer_id, $list_writerID)){
            		ComicWriter::where('comic_id', $id)->where('writer_id', $writer_id)->delete();
            	}
            }
        }
        /*artist*/
        //each list new chose ID, if id in list no exist in list old chose -> create
        if($list_artistID){
            foreach($list_artistID as $artist_id){
                if(!in_array($artist_id, $array_artistID)){
                    ComicArtist::create(['comic_id' => $id, 'artist_id' => $artist_id]);
                }
            }
        }
        //each list old chose ID, if id in list no exist in list new chose -> delete
        if(isset($list_artistID) && $list_artistID != null){
            foreach($array_artistID as $artist_id){
                if(!in_array($artist_id, $list_artistID)){
                    ComicArtist::where('comic_id', $id)->where('artist_id', $artist_id)->delete();
                }
            }
        }

        //Update comic type is of comic
        $array_mediaID = [];
        if($request->image && $request->image != '') $array_mediaID[] = $request->image;
        Media::whereIn('id', $array_mediaID)->update(['image_of' => 'comic']);
        foreach($array_mediaID as $media_id){
            $media_comic = MediaComic::where('image_of', 'comic')->where('post_id', $comic->id)->where('media_id', $media_id)->first();
            if(!$media_comic)
                MediaComic::create(['post_id' => $comic->id, 'media_id' => $media_id, 'image_of' => 'comic']);
        }
        return response()->json(['success' => 'Cập nhật thành công.']);
	}

	public function delete($id){
		$seo = Seo::where('post_id',$id)->where('type','comic')->delete();
        $item = Comic::findOrFail($id);
        $item->delete();
        return redirect()->route('comicsAdmin')->with('success','Xoá thành công.');
	}

	public function deleteAll(Request $request){
        $message = "error";
        if($request->ajax()){
            $items = json_decode($request->items);
            if(count($items)>0){
                Comic::destroy($items);
                Seo::whereIn('post_id', $items)->where('type', 'comic')->delete();
            }
            $message = "success";
        }
        return $message;
	}
    public function createPermission(Request $request, $permission) {
        return Permission::firstOrCreate(['name' => $permission]);
    }

}