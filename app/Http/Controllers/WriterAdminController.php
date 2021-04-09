<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Writer;
use App\Seo;
use Validator;

class WriterAdminController extends Controller
{
	public function index(Request $request){
		$user = Auth::user();
        $user_id= $user->id;
		if($request->ajax()){
			$list_writer = Writer::query();
			if(isset($request->s) && $request->s != '')
				$list_writer = $list_writer->where('title', 'like', '%'. $request->s .'%');
			if(check_editor()){
				$list_writer = $list_writer->where('user_id',$user_id)->orderBy('title')->paginate(14);
			}else{
				$list_writer = $list_writer->orderBy('title')->paginate(14);
			}
			$html = view('backend.writers.table', ['list_writer' => $list_writer])->render();
			return response()->json(['html' => $html]);
		}
		if(check_editor()){
			$list_writer = Writer::where('user_id',$user_id)->orderBy('title')->paginate(14);
		}else{
			$list_writer = Writer::orderBy('title')->paginate(14);
		}
		$data = [];
		$data['list_writer'] = $list_writer;
		return view('backend.writers.list', $data);
	}

	public function create(){
		return view('backend.writers.create');
	}

	public function store(Request $request){
		Writer::stripXSS();
		$list_rules = [];
        $list_rules['title'] = 'required';

		$validator = Validator::make($request->all(), $list_rules);

		if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);

        $request['slug'] = $request->title;
        $request['user_id'] = Auth::id();
        //insert to DB
        $writer = Writer::create($request->only('title','slug','user_id'));
        Seo::addNew($request->meta_key, $request->meta_value, $writer->id, 'comic_writer');
        return response()->json(['success' => 'Add to success.', 'url' => route('createWriterAdmin')]);
	}

	public function edit($id){
		$writer = Writer::findOrFail($id);
		$data = [];
		$data['writer'] = $writer;
		return view('backend.writers.edit', $data);
	}

	public function update($id, Request $request){
		Writer::stripXSS();
		$list_rules = [];
        $list_rules['title'] = 'required';

		$validator = Validator::make($request->all(), $list_rules);

		if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);

        $request['slug'] = str_slug($request->title, '-');
        Seo::updateSeo($request->meta_key, $request->meta_value, $id, 'comic_writer');
		unset($request['_token']);

        //update to DB
        $writer = Writer::where('id', $id)->update($request->only('title'));
        return response()->json(['success' => 'Update to success.']);

	}

	public function delete($id){
        $item = Writer::findOrFail($id);
        $seo = Seo::where('post_id',$id)->where('type','comic_writer')->delete();
        $item->delete();
        return redirect()->route('writersAdmin')->with('success','Deleted Successful');
	}

	public function deleteAll(Request $request){
        if($request->ajax()){
            $items = json_decode($request->items);
            if(count($items)>0){
            	Seo::whereIn('post_id', $items)->where('type','comic_writer')->delete();
                Writer::destroy($items);
            }
            $list_writer = Writer::latest()->paginate(14);
            $data = [];
            $data['list_writer'] = $list_writer;
            return response()->json(['msg' => 'success', 'html' => view('backend.writers.table', $data)->render()]);
        }
        return response()->json(['msg' => 'error']);
	}
}