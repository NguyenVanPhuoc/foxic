@extends('backend.layout.index')
@section('title', __('Thêm Sticker'))
@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container">
            <div class="head">
                <a href="{{route('admin.stickers')}}" class="back-icon"><i class="fas fa-angle-left" aria-hidden="true"></i>{{ __('Tất cả') }}</a>
                <h1 class="title">{{ __('Thêm Sticker') }}</h1>
            </div>
            <div class="main">
                <div id="dropzone"> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('Tiêu đề') }}</label>
                                <input type="text" class="form-control frm_title" placeholder="{{ __('Nhập tiêu đề stickers') }}">
                            </div>
                            <div class="form-group">
                                <label>{{ __('Nhóm Sticker') }}</label>
                                <select class="select2 form-control frm_cate">
                                    @if($cates)
                                        @foreach($cates as $cate)
                                            <option value="{{ $cate->id }}">{{ $cate->title }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 content">
                            <form id="frmTarget" action="{{ route('admin.sticker_store') }}" class="dropzone">
                                {{ csrf_field() }}
                                <div class="dz-message needsclick">{{ __('Thả file ảnh ở đây hoặc bấm vào để tải lên.') }}</div>
                            </form>
                        </div>
                    </div>
                    <div class="gr-action">
                        <input type="hidden" name="title" value="">
                        <input type="hidden" name="cate_id" value="">
                        <button type="submit" name="submit" class="btn">{{ __('Thêm') }}</button>
                        <a href="{{ route('admin.stickers') }}" class="btn btn-cancel">{{ __('Huỷ') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function(){
        var link = $("form").attr('action');
        Dropzone.options.frmTarget = {
            autoProcessQueue: false,
            parallelUploads: 100,
            maxFiles:100,
            url: link,
            init: function () {
                var myDropzone = this;
                $("#dropzone button").click(function (e) {
                    e.preventDefault();
                    $('input[name="title"]').val($('input.frm_title').val());
                    $('input[name="cate_id"]').val($('select.frm_cate').val());
                    myDropzone.processQueue();
                });

                this.on('sending', function(file, xhr, formData) {
                    var data = $('#frmTarget').serializeArray();
                    var title = $('input.frm_title').val();
                    var cate_id = $('select.frm_cate').val();
                    formData.append('title', title);
                    formData.append('cate_id', cate_id);
                });
                this.on("complete", function(file) { 
                    myDropzone.removeFile(file);
                });
            },
            success: function(file, response){
                if(response.msg == 'success')
                    new PNotify({
                        title: 'Thành công',
                        text: response.html,
                        type: 'success',
                        hide: true,
                        delay: 2000,
                    });
                else
                    new PNotify({
                        title: 'Lỗi',
                        text: response.html,
                        type: 'error',
                        hide: true,
                        delay: 2000,
                    });
            }
        }   

    });
</script>
@endsection