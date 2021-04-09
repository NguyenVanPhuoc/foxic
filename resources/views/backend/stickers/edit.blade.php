@extends('backend.layout.index')
@section('title', __('Sửa Sticker'))
@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container">
            <div class="head">
                <a href="{{route('admin.stickers')}}" class="back-icon"><i class="fas fa-angle-left" aria-hidden="true"></i>{{ __('Tất cả') }}</a>
                <h1 class="title">{{ __('Sửa Sticker') }}</h1>
            </div>
            @include('notices.index')
            <div class="main">
                <form action="{{ route('admin.sticker_update',['id'=>$sticker->id]) }}" class="dev-form" method="POST" data-toggle="validator" role="form">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">{{ __('Tiêu đề') }} <small>(*)</small></label>
                                <input type="text" name="title" value="{{ $sticker->title }}" class="form-control" data-error="{{ __('Nhập tiêu đề')}}" required>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{ __('Sticker Package') }} <small>(*)</small></label>
                                <select class="form-control" name="cate_id">
                                    @if($cates)
                                        @foreach($cates as $cate)
                                            <option value="{{ $cate->id }}"{{ $cate->id == $sticker->cate_id ? ' selected' : '' }}>{{ $cate->title }}</option>
                                        @endforeach
                                    @endif                                    
                                </select>
                            </div>                                                        
                        </div>
                        <div class="col-md-6">
                            {!! $sticker->show_sticker(150, 150) !!}
                        </div>
                    </div>
                    <div class="group-action">
                        <button type="submit" name="submit" class="btn btn-success">{{ __('Lưu') }}</button>
                        <a href="{{ route('admin.stickers') }}" class="btn btn-secondary">{{ __('Huỷ') }}</a>  
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection