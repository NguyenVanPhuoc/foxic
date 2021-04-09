<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Comment;
use App\Comic;
use App\Sticker;
use App\StickerCate;
use Validator;

class CommentController extends Controller {

	public function loadMore(Request $request, $comic_id){
		$comic = Comic::select('id')->find($comic_id);
		$offset = (intval($request->current) * 5);
		if($comic) {
			$comment_query = function($query) {
                $query->latest()->published();
            };
			$comments = Comment::with(['children'=>$comment_query])->where('comic_id', $comic_id)->where('parent_id', 0)->latest()->offset($offset)->limit(5)->published()->get();
			$total = Comment::where('parent_id', 0)->published()->count();
			$html = '';
			if($comments) {			
				foreach ($comments as $comment) {
					$sticker_packages_count = StickerCate::with('stickers')->hasStickers()->count();
					$user_id = $comment->user_id;
					$sticker_packages = StickerCate::with('stickers')
			                                        ->hasStickers()
			                                        ->whereHas('users',function($query) use ($user_id) {
			                                            return $query->where('user_id', $user_id);
			                                        })->orWhere('amount', '<=', 0)
			                                        ->latest()->get();
					$html .= view('parts.comment-item', ['comment'=>$comment,'sticker_packages_count' => $sticker_packages_count,'sticker_packages' => $sticker_packages,])->render();
				}
			}
			return json_encode(array('check' => 'true', 'html' => $html, 'has_load' => $total > ($offset + 6)));
		}else{
			return json_encode(array('check' => 'false', 'html' => $html, 'has_load' => $total > ($offset + 6)));
		}
	}

	public function store(Request $request, $comic_id){
		Comment::stripXSS();
		$comic = Comic::find($comic_id);
		if($comic) {
			$request['content'] = $request->frm_content;
			$request['comic_id'] = $comic_id;
			$rules = [
	            'content'=>'required',
	        ];
	        $messages = [
	            'content.required'=>'Vui lòng nhập nội dung bình luận!',
	        ];
	        $validator = Validator::make($request->all(), $rules, $messages);
			if ($validator->fails()) return redirect()->route('listChap',['slugComic'=>$comic->slug])->withErrors($validator)->withInput();
			else{
				if($request->type == 'sticker') {
					$sticker = Sticker::select('id')->find($request->content);
					if($sticker) {
						if(Auth::user()->hasSticker($request->content)) {
							$comment = Comment::create(['comic_id'=>$comic_id, 'user_id'=>Auth::id(), 'content'=>$request->frm_content, 'status'=>'published', 'type' => 'sticker']);
							$request->session()->flash('success', 'Bình luận thành công!');
						}else $request->session()->flash('error', 'Vui lòng thêm gói stickers để sử dụng sticker này!');
					}else $request->session()->flash('error', 'Sticker này không tồn tại!');
				}else{
					$comment = Comment::create(['comic_id'=>$comic_id, 'user_id'=>Auth::id(), 'content'=>$request->frm_content, 'status'=>'published', 'type' => 'text']);
					$request->session()->flash('success', 'Bình luận thành công!');
				}
			}
            return redirect()->route('listChap',['slugComic'=>$comic->slug]);
		}else{
			$request->session()->flash('error', 'Không tìm thấy truyện!');
            return redirect()->route('home');
		}
	}

	public function reply(Request $request, $comment_id){
		Comment::stripXSS();
		if($request->content == '') return json_encode(array('check' => 'false', 'messages' => 'Vui lòng nhập nội dung bình luận!'));
		$comment = Comment::find($comment_id);

		if($comment) {
			if(isset($request->type) && $request->type == 'sticker') {
				$sticker = Sticker::select('id')->find($request->content);

				if($sticker) {

					if(Auth::user()->hasSticker($request->content)) {
						$newCMT = Comment::create(['comic_id'=>$comment->comic_id, 'user_id'=>Auth::id(), 'content'=>$request->content, 'status'=>'published', 'type' => 'sticker', 'parent_id'=>$comment_id]);
						$html = view('parts.comment-item-child', ['comment_child'=>$newCMT])->render();
						return json_encode(array('check' => 'true', 'messages' => 'Trả lời bình luận thành công!', 'html' => $html));
					}else return json_encode(array('check' => 'false', 'messages' => 'Vui lòng thêm gói stickers để sử dụng sticker này!'));

				}else return json_encode(array('check' => 'false', 'messages' => 'Sticker này không tồn tại!'));

			}else{
				$newCMT = Comment::create(['comic_id'=>$comment->comic_id, 'user_id'=>Auth::id(), 'content'=>$request->content, 'status'=>'published', 'type' => 'text', 'parent_id'=>$comment_id]);
				$html = view('parts.comment-item-child', ['comment_child'=>$newCMT])->render();
				return json_encode(array('check' => 'true', 'messages' => 'Trả lời bình luận thành công!', 'html' => $html));
			}
			
		}else return json_encode(array('check' => 'false', 'messages' => 'Comment không tồn tại!'));
	}

	public function edit(Request $request, $comment_id){
		if(Auth::check()) {
			$comment = Comment::where('user_id', Auth::id())->where('id', $comment_id)->first();
			if($comment) {
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
				$html = view('parts.edit-form-comment', $data)->render();
				return json_encode(array('check' => 'true', 'html' => $html));
			}else return json_encode(array('check' => 'false', 'messages' => 'Bạn không có quyền cập nhật comment này!'));
		}else return json_encode(array('check' => 'false', 'messages' => 'Bạn chưa đăng nhập!'));
	}

	public function update(Request $request, $comment_id){
		Comment::stripXSS();
		$comment = Comment::findOrFail($comment_id);
		$user = Auth::user();
		if(Auth::id() == $comment->user_id) {
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
				$comment->content = $request->cmt_content;
				$comment->type = 'text';
				$comment->save();
				$request->session()->flash('success', 'Cập nhật thành công!');
			}
		}else $request->session()->flash('error', 'Bạn không đủ quyền để thực hiện sửa comment này!');
		return redirect()->route('listChap',['slugComic'=>$comment->comic->slug]);
	}

	public function delete(Request $request, $comment_id){
		$comment = Comment::find($comment_id);
		if($comment) {
			$childen = Comment::select('id', 'parent_id')->where('parent_id', $comment->id)->pluck('id')->toArray();
			$user = Auth::user();
			if($user->id == $comment->user_id) {
				if($comment->delete()) Comment::destroy($childen);
				$request->session()->flash('success', 'Xoá thành công!');
			}else $request->session()->flash('error', 'Bạn không đủ quyền để thực hiện hành động này!');
			return redirect()->route('listChap',['slugComic'=>$comment->comic->slug]);
		}else $request->session()->flash('error', 'Comment không tồn tại!');		
		return redirect()->back();
	}
}