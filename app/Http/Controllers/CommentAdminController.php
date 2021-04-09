<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Comment;
use App\Comic;
use App\User;
use App\StickerCate;
use App\Sticker;
use Validator;

class CommentAdminController extends Controller {

	public function index(Request $request){
		$keyword = isset($request->keyword) ? $request->keyword : '';
		$comic_id = isset($request->comic_id) ? $request->comic_id : '';
		$comments = Comment::query();
		if($keyword != '') $comments = $comments->where('content', 'like', '%'.$keyword.'%');
		if($comic_id != '') $comments = $comments->where('comic_id', $comic_id);
		$comments = $comments->with(['comic:id,title', 'user:id,name'])->latest()->paginate(20);
		$data = [
			'keyword' => $keyword,
			'comments' => $comments,
			'comic_id' => $comic_id,
			'comics' => Comic::select('id', 'title', 'status')->get(),
		];
		return view('backend.comments.list', $data);
	}

	public function create(Request $request){
		return view('backend.comments.create');
	}

	public function store(Request $request){
		$data = [
		];
		return view('backend.comments.list', $data);
	}

	public function edit(Request $request, $id){
		$comment = Comment::findOrFail($id)->load(['comic:id,title','user:id,name']);
		$sticker_packages_count = StickerCate::with('stickers')->hasStickers()->count();
		$user_id = $comment->user_id;
        $sticker_packages = StickerCate::with('stickers')
                                        ->hasStickers()
                                        ->whereHas('users',function($query) use ($user_id) {
                                            return $query->where('user_id', $user_id);
                                        })->orWhere('amount', '<=', 0)
                                        ->latest()->get();
		$data = [
			'comment' => $comment,
			'sticker_packages_count' => $sticker_packages_count,
            'sticker_packages' => $sticker_packages,
		];
		return view('backend.comments.edit', $data);
	}

	public function update(Request $request, $id){
		Comment::stripXSS();
		$comment = Comment::findOrFail($id);
		$user = User::find($comment->user_id);
		if(Auth::user()->hasPermissionTo('comment.update') || Auth::id() == $comment->user_id) {
			if($request->cmt_type == 'sticker') {
				$request['content'] = $request->sticker_cmt;
				$sticker = Sticker::select('id')->find($request->content);
				if($sticker) {
					if($user->hasSticker($request->content)) {
						$comment->content = $request->content;
						$comment->type = 'sticker';
						$comment->save();
						$request->session()->flash('success', 'Cập nhật thành công!');
					}else $request->session()->flash('error', 'User chưa mua gói stickers để có thể sử dụng sticker này!');
				}else $request->session()->flash('error', 'Sticker này không tồn tại!');
			}else{
				$comment->content = $request->content;
				$comment->type = 'text';
				$comment->save();
				$request->session()->flash('success', 'Cập nhật thành công!');
			}
		}else $request->session()->flash('error', 'Bạn không đủ quyền để thực hiện hành động này!');
		return redirect()->route('admin.comment_edit',['id'=>$id]);
	}

	public function delete(Request $request, $id){
		$comment = Comment::findOrFail($id);
		$childen = Comment::select('id', 'parent_id')->where('parent_id', $comment->id)->pluck('id')->toArray();
		$user = User::find($comment->user_id);
		if(Auth::user()->hasPermissionTo('comment.delete') || Auth::id() == $comment->user_id) {
			if($comment->delete()) Comment::destroy($childen);
			$request->session()->flash('success', 'Xoá thành công!');
		}else $request->session()->flash('error', 'Bạn không đủ quyền để thực hiện hành động này!');
		return redirect()->route('admin.comments');
	}

	public function deleteAll(Request $request){
		return '132';
		if($request->ajax()){
            $items = json_decode($request->items);
            if(count($items)>0){
            	$childen = Comment::select('id', 'parent_id')->whereIn('parent_id', $items)->pluck('id')->toArray();
	        	if(Auth::user()->hasPermissionTo('comment.delete')) {
					Comment::destroy($items);
					Comment::destroy($childen);
				}
            }
            return response()->json(['msg' => 'success']);
        }
        return response()->json(['msg' => 'error']);
	}
}