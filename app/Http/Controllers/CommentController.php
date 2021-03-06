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
	            'content.required'=>'Vui l??ng nh???p n???i dung b??nh lu???n!',
	        ];
	        $validator = Validator::make($request->all(), $rules, $messages);
			if ($validator->fails()) return redirect()->route('listChap',['slugComic'=>$comic->slug])->withErrors($validator)->withInput();
			else{
				if($request->type == 'sticker') {
					$sticker = Sticker::select('id')->find($request->content);
					if($sticker) {
						if(Auth::user()->hasSticker($request->content)) {
							$comment = Comment::create(['comic_id'=>$comic_id, 'user_id'=>Auth::id(), 'content'=>$request->frm_content, 'status'=>'published', 'type' => 'sticker']);
							$request->session()->flash('success', 'B??nh lu???n th??nh c??ng!');
						}else $request->session()->flash('error', 'Vui l??ng th??m g??i stickers ????? s??? d???ng sticker n??y!');
					}else $request->session()->flash('error', 'Sticker n??y kh??ng t???n t???i!');
				}else{
					$comment = Comment::create(['comic_id'=>$comic_id, 'user_id'=>Auth::id(), 'content'=>$request->frm_content, 'status'=>'published', 'type' => 'text']);
					$request->session()->flash('success', 'B??nh lu???n th??nh c??ng!');
				}
			}
            return redirect()->route('listChap',['slugComic'=>$comic->slug]);
		}else{
			$request->session()->flash('error', 'Kh??ng t??m th???y truy???n!');
            return redirect()->route('home');
		}
	}

	public function reply(Request $request, $comment_id){
		Comment::stripXSS();
		if($request->content == '') return json_encode(array('check' => 'false', 'messages' => 'Vui l??ng nh???p n???i dung b??nh lu???n!'));
		$comment = Comment::find($comment_id);

		if($comment) {
			if(isset($request->type) && $request->type == 'sticker') {
				$sticker = Sticker::select('id')->find($request->content);

				if($sticker) {

					if(Auth::user()->hasSticker($request->content)) {
						$newCMT = Comment::create(['comic_id'=>$comment->comic_id, 'user_id'=>Auth::id(), 'content'=>$request->content, 'status'=>'published', 'type' => 'sticker', 'parent_id'=>$comment_id]);
						$html = view('parts.comment-item-child', ['comment_child'=>$newCMT])->render();
						return json_encode(array('check' => 'true', 'messages' => 'Tr??? l???i b??nh lu???n th??nh c??ng!', 'html' => $html));
					}else return json_encode(array('check' => 'false', 'messages' => 'Vui l??ng th??m g??i stickers ????? s??? d???ng sticker n??y!'));

				}else return json_encode(array('check' => 'false', 'messages' => 'Sticker n??y kh??ng t???n t???i!'));

			}else{
				$newCMT = Comment::create(['comic_id'=>$comment->comic_id, 'user_id'=>Auth::id(), 'content'=>$request->content, 'status'=>'published', 'type' => 'text', 'parent_id'=>$comment_id]);
				$html = view('parts.comment-item-child', ['comment_child'=>$newCMT])->render();
				return json_encode(array('check' => 'true', 'messages' => 'Tr??? l???i b??nh lu???n th??nh c??ng!', 'html' => $html));
			}
			
		}else return json_encode(array('check' => 'false', 'messages' => 'Comment kh??ng t???n t???i!'));
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
			}else return json_encode(array('check' => 'false', 'messages' => 'B???n kh??ng c?? quy???n c???p nh???t comment n??y!'));
		}else return json_encode(array('check' => 'false', 'messages' => 'B???n ch??a ????ng nh???p!'));
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
						$request->session()->flash('success', 'C???p nh???t th??nh c??ng!');
					}else $request->session()->flash('error', 'User ch??a mua g??i stickers ????? c?? th??? s??? d???ng sticker n??y!');
				}else $request->session()->flash('error', 'Sticker n??y kh??ng t???n t???i!');
			}else{
				$comment->content = $request->cmt_content;
				$comment->type = 'text';
				$comment->save();
				$request->session()->flash('success', 'C???p nh???t th??nh c??ng!');
			}
		}else $request->session()->flash('error', 'B???n kh??ng ????? quy???n ????? th???c hi???n s???a comment n??y!');
		return redirect()->route('listChap',['slugComic'=>$comment->comic->slug]);
	}

	public function delete(Request $request, $comment_id){
		$comment = Comment::find($comment_id);
		if($comment) {
			$childen = Comment::select('id', 'parent_id')->where('parent_id', $comment->id)->pluck('id')->toArray();
			$user = Auth::user();
			if($user->id == $comment->user_id) {
				if($comment->delete()) Comment::destroy($childen);
				$request->session()->flash('success', 'Xo?? th??nh c??ng!');
			}else $request->session()->flash('error', 'B???n kh??ng ????? quy???n ????? th???c hi???n h??nh ?????ng n??y!');
			return redirect()->route('listChap',['slugComic'=>$comment->comic->slug]);
		}else $request->session()->flash('error', 'Comment kh??ng t???n t???i!');		
		return redirect()->back();
	}
}