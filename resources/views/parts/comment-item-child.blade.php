@if($comment_child)
	<div class="flex-list">
		<div class="avatar">{!! isset($comment_child->user) ? $comment_child->user->get_avatar() : image('', 45, 45, __('Avatar')) !!}</div>
		<div class="cmt-content">
			<h4 class="user-info">{{ isset($comment_child->user) ? $comment_child->user->show_name() : __('Customer') }}<span>{{ timeElapsedString($comment_child->created_at) }}</span></h4>
			<div class="box-ct">
				@if($comment_child->isSticker())
					{!! $comment_child->showStickerComment('auto', 65) !!}
				@else
					{{ $comment_child->showComment() }}
				@endif
			</div>
			@if(Auth::id() == $comment_child->user_id)
				<div class="edit_comment">
					<a href="javascript:void(0)"><i class="fa fa-ellipsis-v"></i></a>
					<ul class="list-action">
						<li><a href="{{ route('comment.edit',['comment_id'=>$comment_child->id]) }}" class="edit_cmt">{{ __('Chỉnh sửa') }}</a></li>
						<li><a href="{{ route('comment.delete',['comment_id'=>$comment_child->id]) }}" class="delete_cmt">{{ __('Xoá') }}</a></li>	
					</ul>
				</div>
			@endif								
		</div>
	</div>
@endif