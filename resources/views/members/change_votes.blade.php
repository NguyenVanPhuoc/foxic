@extends('templates.master')
@section('title','Đổi phiếu')
@section('content')
<div id="change_votes" class="page profile">
	<div class="container">
		<ul class="filters-list nav nav-tabs">
  			<li class="active"><a data-toggle="tab" href="#xu">Xu</a></li>
  			<li><a data-toggle="tab" href="#point">Point</a></li>
  		</ul>
  		<div class="tab-content">
        {!!csrf_field()!!}
  			<div id="xu" class="tab-pane fade in active">
  				<div class="list-xu list-change-nvp" data-link="{{ route('changeVoteXu') }}">
            @foreach($list_xu as $item)
  					<div class="item">
  						<div class="desc-left">
  							<img src="{{ asset('public/images/icons/img-rent-ticket.png') }}" alt="rent">
  							<h4 class="title">{{ $item->title }}</h4>
  							<p>{{ $item->amount }} xu</p>
  						</div>
  						<div class="desc-right">
  							<span class="btn btn-change-xu" data-id="{{ $item->id }}">{{ $item->amount }} xu</span>
  						</div>
  					</div>
            @endforeach
  				</div>
  			</div>
  			<div id="point" class="tab-pane fade">
  				<div class="list-point list-change-nvp" data-link="{{ route('changeVotePoint') }}">
            @foreach($list_point as $item)
  					<div class="item">
  						<div class="desc-left">
  							<img src="{{ asset('public/images/icons/img-rent-ticket.png') }}" alt="rent">
  							<h4 class="title">{{ $item->title}}</h4>
  							<p>{{ $item->amount }} point</p>
  						</div>
  						<div class="desc-right">
  							<span class="btn btn-change-point" data-id="{{ $item->id }}">{{ $item->amount }} point</span>
  						</div>
  					</div>
  					@endforeach
  				</div>
  			</div>
  		</div>
	</div>
</div>	
@endsection