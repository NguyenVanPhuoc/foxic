@extends('backend.layout.index')
@section('title','Slides')
@section('content')
@php $key = (isset($_GET["s"]) && $_GET["s"] != '')? $_GET["s"] : '';@endphp
<div id="list-slide" class="content-wrapper slides">
    <!-- Main content -->
    <section class="content">
      <div class="head container">
        <h1 class="title">{{__('Slides')}}</h1>
      </div>
      <div class="main">
        <div class="row search-filter">
          <div class="col-md-6 filter">
              <ul class="nav-filter">
                  <li class="active"><a href="{{route('slidesAdmin')}}">{{__('Tất cả')}}</a></li>
              </ul>
          </div>
        </div>
        <div class="card">
          <div class="card-body p-0">
            @include('notices.index')
            <form class="dev-form" action="{{-- {{route('deleteChooseSlideAdmin')}} --}}" name="listSlide" method="POST" role="form">
             {{ csrf_field() }}
              <table class="table table-striped projects" role="table">
                <thead class="thead">
                  <tr>
                    <th class="title">{{__('Name')}}</th>
                    <th class="count">{{__('Count')}}</th>
                    <th class="date">{{__('Date')}}</th>
                    <th class="action"></th>
                  </tr>
                </thead>
                <tbody class="tbody">
                  @if(!$slides->isEmpty())
                    @foreach($slides as $item)
                    <tr>
                      <td class="title"><a href="{{route('editSlideAdmin',['id'=>$item->id])}}">{{$item->title}}</a></td>
                      <td class="count ">
                        <a href="{{route('editSlideAdmin',['id'=>$item->id])}}">{{count(json_decode($item->content))}}</a>
                      </td>
                      <td class="count">{{ $item->created_at }}</td>
                     
                    </tr>
                    @endforeach
                  @else
                    <tr>
                      <td colspan="6">{{__('No items')}}</td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </form>
          </div>
      </div>
      @if(!$key)
        {{ $slides->links() }}
      @else
        {{ $slides->appends(['s'=>$key])->links() }}
      @endif
      </div>
    </section>
    <!-- /.content -->
  </div>
<!-- Side Modal Top Right -->
@include('modals.modal_delete')
@include('modals.modal_deleteChoose')
@endsection