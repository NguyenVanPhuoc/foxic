@extends('backend.layout.index')
@section('title', __('Stickers'))
@section('content')
<div class="content-wrapper">
   <section class="content">
      <div class="head container">
         <h1 class="title">{{ __('Stickers') }}</h1>
      </div>
      <div class="main">
         <div class="row search-filter">
            <div class="col-md-6 filter">
               <ul class="nav-filter">
                  <li class="active"><a href="{{ route('admin.stickers') }}">{{ __('Tất cả') }}</a></li>
                  <li class=""><a href="{{ route('admin.sticker_create') }}">{{ __('Thêm mới') }}</a></li>
               </ul>
            </div>
           <!--  <div class="col-md-6 search-form">
               <form name="s" action="{{ route('admin.stickers') }}" method="GET">
                  <div class="row">
                     <div class="col-md-12 s-key">
                        <input type="text" name="keyword" class="form-control s-key" placeholder="{{ __('Keyword') }}" value="{{ $keyword }}">
                     </div>
                     <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                  </div>
               </form>
            </div> -->
            <div class="col-md-6  frm-search">
               <div class="search-form">
                  <form name="s" action="{{ route('admin.stickers') }}" method="GET">
                     <input type="text" name="keyword" class="form-control s-key" placeholder="{{ __('Keyword') }}" value="{{ $keyword }}">
                     <button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>
                  </form>
               </div>
            </div>
         </div>
         <div class="card">
            <div class="card-body p-0">
               @include('notices.index')
               <form class="dev-form" data-delete="{{ route('admin.sticker_delete_choose') }}" method="POST" role="form">
                  {{ csrf_field() }}
                  <div class="table-responsive">
                     <table class="table table-striped projects" role="table">
                        <thead class="thead">
                           <tr>
                              <th id="check-all" class="check"><input type="checkbox" name="checkAll"></th>
                              <th>{{ __('Tiêu đề') }}</th>
                              <th>{{ __('Path') }}</th>
                              <th class="text-center">{{ __('Image') }}</th>
                              <th class="text-center">{{ __('Package') }}</th>
                              <th>{{ __('Date Updated') }}</th>
                              <th class="action"></th>
                           </tr>
                        </thead>
                        <tbody class="tbody">
                           @if(!$stickers->isEmpty())
                           @foreach($stickers as $item)
                           <tr>
                              <td class="check"><input type="checkbox" name="checkbox[]" value="{{ $item->id }}"></td>
                              <td><a href="{{ route('admin.sticker_edit',['id'=>$item->id]) }}">{{ $item->title }}</a></td>
                              <td><a href="{{ route('admin.sticker_edit',['id'=>$item->id]) }}">{{ $item->image_path }}</a></td>
                              <td class="text-center"><a href="{{ route('admin.sticker_edit',['id'=>$item->id]) }}">{!! $item->show_sticker(45,45) !!}</a></td>
                              <td class="text-center">{!! isset($item->cate) ? '<a href="'.route('admin.sticker_cate_edit',['id'=>$item->cate_id]).'">'.$item->cate->title.'</a>' : 'NULL' !!}</td>
                              <td>{{ $item->updated_at }}</td>
                              <td class="action text-right">
                                 <a href="{{ route('admin.sticker_edit',['id'=>$item->id]) }}" class="edit" title="edit"><i class="fal fa-edit"></i></a>
                                 <a href="{{ route('admin.sticker_delete',['id'=>$item->id]) }}" class="btn-delete delete" title="delete"><i class="fal fa-times"></i></a>
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
            {{ $stickers->appends(['keyword'=>$keyword])->links() }}
         @else
            {{ $stickers->links() }}
         @endif
      </div>
   </section>
   <!-- /.content -->
</div>
<!-- Side Modal Top Right -->
@endsection