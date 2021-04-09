@if($comment)
    <form action="{{ route('comment.update',['comment_id'=>$comment->id]) }}" method="POST">
        {{ csrf_field() }}
        <div class="form-group">
            <label><strong>{{ __('Loại bình luận') }}</strong></label>
            <div class="radio-cs">
                <label for="CMT-type">
                    <input type="radio" name="cmt_type" value="comment" id="CMT-type"{{ $comment->isSticker() ? '' : ' checked' }}>
                    <span>{{ __('Bình luận bằng text') }}</span>
                </label>
            </div>
            <div class="radio-cs">
                <label for="CMT-sticker">
                    <input type="radio" name="cmt_type" value="sticker" id="CMT-sticker"{{ $comment->isSticker() ? ' checked' : '' }}>
                    <span>{{ __('Bình luận bằng Sticker') }}</span>
                </label>
            </div>
        </div>
        <div class="form-group comment__content{{ $comment->isSticker() ? ' not-show' : '' }}">
            <label>{{ __('Nội dung') }}</label>
            <textarea class="form-control" rows="3" name="cmt_content">{{ $comment->isSticker() ? '' : $comment->content }}</textarea>
        </div>
        <div class="form-group comment__sticker{{ $comment->isSticker() ? '' : ' not-show' }}">
            <label>{{ __('Sticker') }}</label>
            <input type="hidden" name="sticker_cmt" value="{{ $comment->isSticker() ? $comment->content : '' }}">
            @if($comment->isSticker())
                <div class="text-center current_sticker">{!! $comment->showStickerComment('auto', 100) !!}</div>
            @else
                <div class="text-center current_sticker"></div>
            @endif
            @include('parts.sticker-packages')
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">{{ __('Cập nhật') }}</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Huỷ') }}</button>
        </div>
    </form>       
@endif