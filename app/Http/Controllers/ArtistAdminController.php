<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Artist;
use App\ComicArtist;
use App\Seo;
use Validator;

class ArtistAdminController extends Controller
{
	public function index(Request $request){
		$user = Auth::user();
        $user_id= $user->id;
		if($request->ajax()){
			$list_artist = Artist::query();
			if(isset($request->s) && $request->s != '')
				$list_artist = $list_artist->where('title', 'like', '%'. $request->s .'%');
			if(check_editor()){
				$list_artist = $list_artist->where('user_id',$user_id)->orderBy('title')->paginate(14);
			}else{
				$list_artist = $list_artist->orderBy('title')->paginate(14);
			}
			$html = view('backend.artists.table', ['list_artist' => $list_artist])->render();
			return response()->json(['html' => $html]);
		}
		if(check_editor()){
			$list_artist = Artist::where('user_id',$user_id)->orderBy('title')->paginate(14);
		}else{
			$list_artist = Artist::orderBy('title')->paginate(14);
		}
		$data = [];
		$data['list_artist'] = $list_artist;
		return view('backend.artists.list', $data);
	}

	public function create(){
		return view('backend.artists.create');
	}

	public function store(Request $request){
		Artist::stripXSS();
		$list_rules = [];
        $list_rules['title'] = 'required';

		$validator = Validator::make($request->all(), $list_rules);

		if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);

        $request['slug'] = $request->title;
        $request['user_id'] = Auth::id();

        //insert to DB
        $artist = Artist::create($request->only('title','slug', 'user_id'));
        Seo::addNew($request->meta_key, $request->meta_value, $artist->id, 'comic_artist');
        return response()->json(['success' => 'Add to success.', 'url' => route('createArtistAdmin')]);
	}

	public function edit($id){
		$artist = Artist::findOrFail($id);
		$data = [];
		$data['artist'] = $artist;
		return view('backend.artists.edit', $data);
	}

	public function update($id, Request $request){
		Artist::stripXSS();
		$list_rules = [];
        $list_rules['title'] = 'required';

		$validator = Validator::make($request->all(), $list_rules);

		if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);

        $request['slug'] = str_slug($request->title, '-');
        Seo::updateSeo($request->meta_key, $request->meta_value, $id, 'comic_artist');
		unset($request['_token']);

        //update to DB
        $artist = Artist::where('id', $id)->update($request->only('title'));
        return response()->json(['success' => 'Update to success.']);

	}

	public function delete($id){
        $item = Artist::findOrFail($id);
        $item->delete();
        $seo = Seo::where('post_id',$id)->where('type','comic_artist')->delete();
        return redirect()->route('artistsAdmin')->with('success','Deleted Successful');
	}

	public function deleteAll(Request $request){
        if($request->ajax()){
            $items = json_decode($request->items);
            if(count($items)>0){
            	Seo::whereIn('post_id', $items)->where('type','comic_artist')->delete();
                Artist::destroy($items);
            }
            $list_artist = Artist::latest()->paginate(14);
            $data = [];
            $data['list_artist'] = $list_artist;
            return response()->json(['msg' => 'success', 'html' => view('backend.artists.table', $data)->render()]);
        }
        return response()->json(['msg' => 'error']);
	}
}