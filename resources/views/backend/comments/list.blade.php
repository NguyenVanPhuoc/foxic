@extends('backend.layout.index')
@section('title', __('Comments'))
@section('content')
<div class="content-wrapper" id="comments">
   <section class="content">
      <div class="head container">
         <h1 class="title">{{ __('Comments') }}</h1>
      </div>
      <div class="main">
         <div class="row search-filter">
            <div class="col-md-6 filter">
               <ul class="nav-filter">
                  <li class="active"><a href="{{ route('admin.comments') }}">{{ __('Tất cả') }}</a></li>
                  {{-- <li class=""><a href="{{ route('admin.comment_create') }}">{{ __('Thêm mới') }}</a></li> --}}
               </ul>
            </div>
            <div class="col-md-6 frm-search">
               <div class="search-form">
                  <form name="s" action="{{ route('admin.comments') }}" method="GET">
                     <div class="row">
                        <div class="col-md-6">
                           <select class="select2 form-control" name="comic_id">
                              <option value="">---Chọn Truyện---</option>
                              @if($comics)
                                 @foreach($comics as $comic)
                                    <option value="{{ $comic->id }}"{{ $comic->id == $comic_id ? ' selected' : '' }}>{{ $comic->title }}</option>
                                 @endforeach
                              @endif
                           </select>
                        </div>
                        <div class="col-md-6 s-key">
                           <input type="text" name="keyword" class="form-control s-key" placeholder="{{ __('Keyword') }}" value="{{ $keyword }}">
                        </div>
                        <div class=" btn-marow">
                           <button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
         <div class="card">
            <div class="card-body p-0">
               @include('notices.index')
               <form class="dev-form" data-delete="{{ route('admin.comments_delete_choose') }}" method="POST" role="form">
                  {{ csrf_field() }}
                  <div class="table-responsive">
                     <table class="table table-striped projects" role="table">
                        <thead class="thead">
                           <tr>
                              <th id="check-all" class="check"><input type="checkbox" name="checkAll"></th>
                              <th>{{ __('Username') }}</th>
                              <th>{{ __('Bình luận') }}</th>
                              <th class="text-center">{{ __('Truyện') }}</th>
                              <th class="text-center">{{ __('Date Created') }}</th>
                              <th class="text-center">{{ __('Reply of') }}</th>
                              <th class="action"></th>
                           </tr>
                        </thead>
                        <tbody class="tbody">
                           @if(!$comments->isEmpty())
                           @foreach($comments as $item)
                           <tr>
                              <td class="check"><input type="checkbox" name="checkbox[]" value="{{ $item->id }}"></td>
                              <td>{!! isset($item->user) ? '<a href="'.route('editAdmin',['id'=>$item->user_id]).'">'.$item->user->show_name().'</a>' : 'Customer' !!}</td>
                              <td><a href="{{ route('admin.comment_edit',['id'=>$item->id]) }}">
                                 @if($item->isSticker())
                                    {!! $item->showStickerComment('auto', 50) !!}
                                 @else
                                    {{ str_limit($item->showComment(), 75, '...') }}
                                 @endif
                              </a></td>
                              <td class="text-center">
                                 @if(isset($item->comic))
                                    <a href="{{ route('editComicAdmin',['id'=>$item->comic_id]) }}">{{ $item->comic->title }}</a>
                                 @else
                                    {{ __('Truyện đã bị xoá!') }}
                                 @endif
                              </td>
                              <td class="text-center">{{ $item->created_at }}</td>
                              <td class="text-center">
                                 @if($item->parent_id != 0)
                                    <a href="{{ route('admin.comment_edit',['id'=>$item->parent_id]) }}">
                                       @if($item->parent->isSticker())
                                          {!! $item->parent->showStickerComment('auto', 50) !!}
                                       @else
                                          {{ str_limit($item->parent->content, 35, '...') }}
                                       @endif
                                    </a>
                                 @endif
                              </td>
                              <td class="action text-right">
                                 <a href="{{ route('admin.comment_edit',['id'=>$item->id]) }}" class="edit" title="edit"><i class="fal fa-edit"></i></a>
                                 <a href="{{ route('admin.comment_delete',['id'=>$item->id]) }}" class="btn-delete delete" title="delete"><i class="fal fa-times"></i></a>
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
         {{ $comments->appends(['keyword'=>$keyword, 'comic_id'=>$comic_id])->links() }}
      </div>
   </section>
</div>
@endsection