<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;
use App\Comment;
use App\Sticker;
use Validator;
use Session;

class CreateNewComment {

    /**
     * Validate and create a newly comment.
     *
     * @param  array  $input
     * @return \App\Comment
     */
    public function create(array $input) {
        $parent = isset($input['parent']) ? $input['parent_id'] : 0;
        $user_id = isset($input['user_id']) ? $input['user_id'] : Auth::id();
        
        $messages = [
            'content.required' => __('Vui lòng nhập nội dung bình luận!'),
        ];
        Validator::make($input, [
            'content' => ['required'],
        ], $messages)->validate();
        if(isset($input['type']) && $input['type'] == 'sticker') {
            $sticker = Sticker::select('id')->find($input['content']);
            if($sticker) {
                if(Auth::user()->hasSticker($input['content'])) {
                    return Comment::create(['comic_id'=>$input['comic_id'], 'user_id'=>$user_id, 'content'=>$input['content'], 'status'=>'published', 'type' => 'sticker'], 'parent_id' => $parent);
                }else{
                    Session::flash('error', 'Vui lòng thêm gói stickers để sử dụng sticker này!');
                    return false;
                }
            }else{
                Session::flash('error', 'Sticker này không tồn tại!');
                return false;
            }
        }else return Comment::create(['comic_id'=>$input['comic_id'], 'user_id'=>$user_id, 'content'=>$input['content'], 'status'=>'published', 'type' => 'text'], 'parent_id' => $parent);
    }
}
