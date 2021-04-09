<h4 class="sec-title">{{ __('Bình luận (').$comic->comments_count.')' }}</h4>
@include('parts.comment-form')
<div class="list-comments">
	@if($comic->comments->count() > 0)
		<div class="list-item">
			@foreach($comic->comments as $comment)
				@include('parts.comment-item')
			@endforeach
		</div>
		@if($total_cmt_par > 5)
			<div class="loadMore text-center">
				<a href="javascript:void(0)" class="load_more btn btn-primary btn-block" data-action="{{ route('comment.load_more',['comic_id'=>$comic->id]) }}">{{ __('Xem thêm bình luận') }}</a>
				<input type="hidden" name="current_page" value="1">
			</div>
		@endif
	@else	
		<p class="notify">{{ __('Chưa có bình luận!') }}</p>
	@endif
</div>