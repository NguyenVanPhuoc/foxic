@extends('backend.layout.index')
@section('title', __('Sửa Package'))
@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container">
            <div class="head">
                <a href="{{route('admin.sticker_cates')}}" class="back-icon"><i class="fas fa-angle-left" aria-hidden="true"></i>{{ __('Tất cả') }}</a>
                <h1 class="title">{{ __('Sửa Package') }}</h1>
            </div>
            @include('notices.index')
            <div class="main">
                <form action="{{ route('admin.sticker_cate_update',['id'=>$cate->id]) }}" name="createPage" class="dev-form" method="POST" data-toggle="validator" role="form">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-9 content">
                            <div class="form-group">
                                <label class="control-label">{{ __('Tiêu đề') }} <small>(*)</small></label>
                                <input type="text" name="title" value="{{ $cate->title }}" class="form-control" data-error="{{ __('Nhập tiêu đề')}}" required>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{ __('Giá mua') }} <small>(*)</small></label>
                                <input type="number" name="amount" value="{{ $cate->amount }}" class="form-control" data-error="{{ __('Nhập giá mua') }}" required>
                                <div class="help-block with-errors"></div>
                            </div>                                                        
                            <div class="group-action">
                                <button type="submit" name="submit" class="btn btn-success">{{ __('Lưu') }}</button>
                                <a href="{{ route('admin.sticker_cates') }}" class="btn btn-secondary">{{ __('Huỷ') }}</a>  
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
  </div>
@endsection