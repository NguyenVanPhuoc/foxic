@if($comment)
	<div class="item-cmt">
		<div class="flex-list">
			<div class="avatar">{!! isset($comment->user) ? $comment->user->get_avatar() : image('', 45, 45, __('Avatar')) !!}</div>
			<div class="cmt-content">
				<h4 class="user-info">{{ isset($comment->user) ? $comment->user->show_name() : __('Customer') }}<span>{{ timeElapsedString($comment->created_at) }}</span></h4>
				<div class="box-ct">
					@if($comment->isSticker())
						{!! $comment->showStickerComment('auto', 75) !!}
					@else
						{{ $comment->showComment() }}
					@endif				
				</div>
				@if(Auth::check())
					<div class="text-right"><a href="javascript:void(0)" class="open-reply-form"><i class="fa fa-reply" aria-hidden="true"></i>{{ __('Trả lời') }}</a></div>
					<form class="form-reply-comment" data-action="{{ route('comment.reply',['comment_id'=>$comment->id]) }}">
						<div class="form-group">
							<textarea class="form-control frm_content" rows="5"></textarea>
						</div>
						<div class="text-right">
							@if($sticker_packages_count > 0)<a href="javascript:void(0)" class="btn btn-default show_sticker">{{ __('Stickers') }}</a>@endif
							<button class="btn btn-primary">{{ __('Gửi ') }}<i class="fa fa-paper-plane"></i></button>
						</div>
						@include('parts.sticker-packages')
					</form>
				@endif
				@if(Auth::id() == $comment->user_id)
					<div class="edit_comment">
						<a href="javascript:void(0)"><i class="fa fa-ellipsis-v"></i></a>
						<ul class="list-action">
							<li><a href="{{ route('comment.edit',['comment_id'=>$comment->id]) }}" class="edit_cmt">{{ __('Chỉnh sửa') }}</a></li>
							<li><a href="{{ route('comment.delete',['comment_id'=>$comment->id]) }}" class="delete_cmt">{{ __('Xoá') }}</a></li>					
						</ul>
					</div>
				@endif
			</div>
		</div>
		<div class="list-replies">
			@if($comment->children)
				@foreach($comment->children as $comment_child)
					@include('parts.comment-item-child')
				@endforeach
			@endif
		</div>
	</div>
@endif