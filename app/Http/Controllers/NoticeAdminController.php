<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Seo;
use App\Notice;
use App\Media;
use App\User;
use Spatie\Permission\Models\Role;
use App\Notifications\DataNotifications;
use Validator;

class NoticeAdminController extends Controller
{
	public function index(Request $request){
		$notices = Notice::latest()->paginate(14);
		$data = [];
		$data ['notices'] = $notices;
		return view('backend.notices.list', $data);
	}

	public function create(){
        $roles= Role::select('id','name')->get();
        $data = [];
        $data ['roles'] = $roles;
		return view('backend.notices.create', $data);
	}

	public function store(Request $request){
		$list_rules = [];
        $list_rules['title'] = 'required';
		$validator = Validator::make($request->all(), $list_rules);
		if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        $request['slug'] = $request->title;
        $notice = new Notice;
        $notice->title = $request->title;
        $notice->slug = $request->slug;
        $notice->content = $request->content;
        $notice->image = $request->image;
        $notice->role = $request->role;
        $notice->type = $request->type;
        $notice->save();
        $array_user = $notice->role != null ? User::role($notice->role)->pluck('id')->toArray() : array();
        if($array_user != null){
            foreach ($array_user as $key => $value) {
                $user = User::find($value);
                $user->notify(new DataNotifications($notice));
            }
        }
        return response()->json(['success' => 'Create Complete', 'url' => route('createNoticeAdmin')]);
	}

	public function edit($id){
		$notice = Notice::findOrFail($id);
        $roles= Role::select('id','name')->get();
		$data = [];
        $data['notice'] = $notice;
        $data['roles'] = $roles;
		return view('backend.notices.edit', $data );
		
	}

	public function update($id, Request $request){
        $notice = Notice::findOrFail($id);
        $list_rules = [];
        $list_rules['title'] = 'required';
        $validator = Validator::make($request->all(), $list_rules);
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        $request['slug'] = $request->title;
        $notice->update($request->only('title', 'slug', 'image', 'content'));
        return response()->json(['success' => 'Update to success.', 'url' => route('editNoticeAdmin', $id)]);
	}

	public function delete($id){
        $notice= \DB::table('notifications')
        ->where('type','App\Notifications\DataNotifications')
        ->where('data->id',intval($id))
        ->delete();
        $item = Notice::findOrFail($id);
        $item->delete();
        return redirect()->route('noticesAdmin')->with('success','Deleted Successful');
	}

	public function deleteAll(Request $request){
        if($request->ajax()){
            $items = json_decode($request->items);
            $notices = Notice::latest()->paginate(14);
            $data = [];
            $data['notices'] = $notices;
            return response()->json(['msg' => 'success', 'html' => view('backend.notices.table', $data)->render()]);
        }
        return response()->json(['msg' => 'error']);
	}

	
}