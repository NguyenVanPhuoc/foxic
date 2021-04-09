@extends('backend.layout.index')
@section('title','Add')
@section('content')
<div id="create-slide" class="content-wrapper media-category slides">
   <!-- Main content -->
   <section class="content">
      <div class="container">
         <div class="head">
            <a href="{{route('slidesAdmin')}}" class="back-icon"><i class="fas fa-angle-left" aria-hidden="true"></i>{{__('Tất cả')}}</a>
            <h1 class="title">{{__('배너 추가')}}</h1>
         </div>
         <div class="main">
            @include('notices.index')
            <form action="{{route('createSlideAdmin')}}" method="POST" name="createSlide" data-toggle="validator" role="form" class="dev-form">
                {{ csrf_field() }}
               <div id="frm-title" class="form-group">
                  <label for="title">{{ __('Name') }}</label>
                  <input type="text" name="title" class="form-control" placeholder="Vui lòng nhập tên " required>
                  <div class="help-block with-errors"></div>
               </div>
               <div id="list-item" class="card card-outline card-info">
                  <div class="card-header">
                     <h3 class="card-title">{{__('Danh sách')}}</h3>
                  </div>
                  <div class="card-body sortable-items list-slide">
                     <div class="list">
                        <ul class="sortable" data-recores="1">
                           <li class="row item" data-position="1">
                              <i class="fas fa-trash" aria-hidden="true"></i>
                              <div id="img-1" class="col-md-3 img-upload">
                                 <div class="image full-width">
                                    <a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                    {!!image('',325,275,'image')!!}
                                    <input type="hidden" name="thumbnail" class="thumb-media" value="" />
                                 </div>
                              </div>
                              {{-- <div class="col-md-9 desc"><textarea name="desc" class="form-control" rows="10"></textarea></div> --}}
                               <div class="col-md-12 link"><input type="text" name="link" class="form-control"/></div>
                           </li>
                        </ul>
                     </div>
                     <button class="btn btn-primary add-row"><i class="fa fa-plus-circle" aria-hidden="true"></i>{{__('Add row')}}</button>
                  </div>
               </div>
               <div class="group-action">
                  <button type="submit" name="submit" class="btn btn-success">{{__('Lưu')}}</button>
                  <a href="{{route('slidesAdmin')}}" class="btn btn-secondary">{{__('Hủy')}}</a>							
               </div>
            </form>
            <div class="att-temp" style="display: none;">
                <ul class="sortable">
                   <li class="row item" data-position="1">
                      <i class="fas fa-trash" aria-hidden="true"></i>
                      <div id="img-1" class="col-md-3 img-upload">
                         <div class="image full-width">
                            <a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
                            {!!image('',325,275,'image')!!}
                            <input type="hidden" name="thumbnail" class="thumb-media" value="" />
                         </div>
                      </div>
                      <div class="col-md-12 link"><input type="text" name="link" class="form-control"/></div>
                   </li>
                </ul>
             </div>
         </div>
      </div>
   </section>
   <!-- /.content -->
</div>
@include('backend.media.library')
<script type="text/javascript">
   $(document).ready(function(){
       $("#create-slide").on('click','.dev-form .group-action .btn-success',function(){
           var _token = $(".dev-form input[name='_token']").val();
           var _action = $(".dev-form").attr("action");
           var title = $("#frm-title input").val();
           var items = new Array();
            var stt = 0;
              $(".list-slide .sortable .item").each(function(){
                 var link = $(this).find("input[name=link]").val();
                 var image = $(this).find("input.thumb-media").val();
                      items[stt] = {
                          'link' : link,
                          'image' : image,
                          'position' : $(this).attr("data-position")
                      }
                      stt++;
             });
           $.ajax({
               type:'POST',            
               url:_action,
               cache: false,
               data:{
                   '_token': _token,
                   'title':title,
                   'items': JSON.stringify(items)
               },
           }).done(function(data) {
               location.reload();
           });
           return false;
       });
   });
</script>
@endsection