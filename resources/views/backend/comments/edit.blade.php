@extends('backend.layout.index')
@section('title', __('Sửa comment'))
@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container">
            <div class="head">
                <a href="{{ route('admin.comments') }}" class="back-icon"><i class="fas fa-angle-left" aria-hidden="true"></i>{{ __('Tất cả') }}</a>
                <h1 class="title">{{ __('Sửa comment') }}</h1>
            </div>
            @include('notices.index')
            <div class="main">
                <form action="{{ route('admin.comment_update',['id'=>$comment->id]) }}" class="dev-form" method="POST" data-toggle="validator" role="form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>{{ __('User') }}</label>
                        <input type="text" readonly disabled class="form-control" value="{{ isset($comment->user) ? $comment->user->show_name() : 'Customer' }}">
                    </div>
                    <div class="form-group">
                        <label>{{ __('Truyện') }}</label>
                        <input type="text" readonly disabled class="form-control" value="{{ isset($comment->comic) ? $comment->comic->title : 'Truyện không tồn tại' }}">
                    </div>
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
                    <div class="form-group">
                        <label>{{ __('Nội dung') }}</label>
                        <textarea class="form-control" rows="3" name="content">{{ $comment->isSticker() ? '' : $comment->showComment() }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Sticker') }}</label>
                        <input type="hidden" name="sticker_cmt" value="{{ $comment->isSticker() ? $comment->showComment() : '' }}">
                        @if($comment->isSticker())
                            <div class="text-center current_sticker">{!! $comment->showStickerComment('auto', 100) !!}</div>
                        @endif
                        @include('parts.sticker-packages')
                    </div>
                    <div class="group-action">
                        <button type="submit" name="submit" class="btn btn-success">{{ __('Lưu') }}</button>
                        <a href="{{ route('admin.comments') }}" class="btn btn-secondary">{{ __('Huỷ') }}</a>  
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection