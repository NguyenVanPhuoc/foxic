@extends('backend.layout.index')
@section('title', __('Sticker Packages'))
@section('content')
<div id="list-events" class="content-wrapper events">
   <section class="content">
      <div class="head container">
         <h1 class="title">{{ __('Sticker Packages') }}</h1>
      </div>
      <div class="main">
         <div class="row search-filter">
            <div class="col-md-6 filter">
               <ul class="nav-filter">
                  <li class="active"><a href="{{ route('admin.sticker_cates') }}">{{ __('Tất cả') }}</a></li>
                  <li class=""><a href="{{ route('admin.sticker_cate_create') }}">{{ __('Thêm mới') }}</a></li>
               </ul>
            </div>
            {{-- <div class="col-md-6 search-form">
               <form name="s" action="{{ route('admin.sticker_cates') }}" method="GET">
                  <div class="row">
                     <div class="col-md-12 s-key">
                        <input type="text" name="keyword" class="form-control s-key" placeholder="{{ __('Keyword') }}" value="{{ $keyword }}">
                     </div>
                     <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                  </div>
               </form>
            </div> --}}
            <div class="col-md-6  frm-search">
               <div class="search-form">
                  <form name="s" action="{{ route('admin.sticker_cates') }}" method="GET">
                     <input type="text" name="keyword" class="form-control s-key" placeholder="{{ __('Keyword') }}" value="{{ $keyword }}">
                     <button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>
                  </form>
               </div>
            </div>
         </div>
         <div class="card">
            <div class="card-body p-0">
               @include('notices.index')
               <form class="dev-form" data-delete="{{ route('admin.sticker_cate_delete_choose') }}" method="POST" role="form">
                  {{ csrf_field() }}
                  <div class="table-responsive">
                     <table class="table table-striped projects" role="table">
                        <thead class="thead">
                           <tr>
                              <th id="check-all" class="check"><input type="checkbox" name="checkAll"></th>
                              <th>{{ __('Tiêu đề') }}</th>
                              <th class="text-center">{{ __('Giá') }}</th>
                              <th class="text-center">{{ __('Số lượng stickers') }}</th>
                              <th>{{ __('Ngày cập nhật') }}</th>
                              <th class="action"></th>
                           </tr>
                        </thead>
                        <tbody class="tbody">
                           @if(!$cates->isEmpty())
                           @foreach($cates as $item)
                           <tr>
                              <td class="check"><input type="checkbox" name="checkbox[]" value="{{ $item->id }}"></td>
                              <td><a href="{{ route('admin.sticker_cate_edit',['id'=>$item->id]) }}">{{ $item->title }}</a></td>
                              <td class="text-center">{{ $item->amount }}</td>
                              <td class="text-center">{{ $item->stickers_count }}</td>
                              <td>{{ $item->updated_at }}</td>
                              <td class="action text-right">
                                 <a href="{{ route('admin.sticker_cate_edit',['id'=>$item->id]) }}" class="edit" title="edit"><i class="fal fa-edit"></i></a>
                                 <a href="{{ route('admin.sticker_cate_delete',['id'=>$item->id]) }}" class="btn-delete delete" title="delete"><i class="fal fa-times"></i></a>
                              </td>
                           </tr>
                           @endforeach
                           @else
                           <tr>
                              <td colspan="6" class="text-center">{{ __('Chưa có dữ liệu!') }}</td>
                           </tr>
                           @endif
                        </tbody>
                     </table>
                  </div>
               </form>
            </div>
         </div>
         @if($keyword != '')
            {{ $cates->appends(['keyword'=>$keyword])->links() }}
         @else
            {{ $cates->links() }}
         @endif
      </div>
   </section>
   <!-- /.content -->
</div>
<!-- Side Modal Top Right -->
@include('modals.modal_delete')
@include('modals.modal_deleteChoose')
@endsection