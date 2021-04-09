@extends('backend.layout.index')
@section('title','Thống kê')
@section('content')
	<div id="pages" class="page statis">
		<div class="head container"><h1 class="title">{{ __('Thống kê') }}</h1></div>
		<form id="statis-frm" action="{{ route('statisticalAdmin') }}" method="GET" name="statis" class="dev-form">
		<div class="row p-15">
			<div class="col-md-4">
				@include('notices.index')
			</div>
			<div class="col-md-8">
				<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/style.css">
				<div class="row">
					<div id="date-start" class="col-md-3">
						<input type="text" class="date-flatpickr" placeholder="--Tháng bắt đầu--" name="startDate" value="{{ isset($startDate) ? $startDate : ''}}">
					</div>
					<div id="date-end" class="col-md-3">
						<input type="text" class="date-flatpickr" placeholder="--Tháng kết thúc--" name="endDate" value="{{ isset($endDate) ? $endDate : ''}}">
					</div>
					<div id="author" class="col-md-4">
						<select name="user_id" class="form-control select2">
							<option value>{{ __('--Chọn tác giả--')}}</option>
							@foreach($author as $key => $item)
								<option value="{{ $item->id }}" {{ isset($user_id) && $user_id==$item->id ? 'selected' : ''}}>{{ $item->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-2">
						<button type="submit" class="btn form-control"><i class="fa fa-search" aria-hidden="true"></i></button>
					</div>
				</div>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-striped list-page">
				<thead>
					<tr>					
						<th class="stt">{{ __('STT') }}</th>
						<th class="title">{{ __('Tác giả') }}</th>
						<th class="author">{{ __('Tổng point (thuê/mua)') }}</th>
						<th class="author">{{ __('Tổng donate') }}</th>
						<th class="author">{{ __('Tổng view') }}</th>
						<th class="author">{{ __('Tổng') }}</th>
						<th class="author">{{ __('Point đã chuyển') }}</th>
						<th class="action">{{ __('Tác vụ') }}</th>
					</tr>
				</thead>
				<tbody>				
					@foreach($user as $key => $item)

					@php
						$point = $item->actions->whereIn('type',['buy','rental'])->sum('point');
						$donate = $item->actions->where('type','donate')->sum('point');
						$view = $item->views->sum('view_month');
						$transfer_point = $item->transfers->count() > 0 ? $item->transfers->sum('point') : 0;
					@endphp
					<tr>
						<td class="text-center">{{ $key+1 }}</td>
						<td class="title">{{ $item->name}}</td>
						<td class="author">{{ $point}} point</td>
						<td class="author">{{ $donate}} point</td>
						<td class="author">{{ $view }} view</td>
						@if($item->type_author == 'official')
							@php $sum = (50/100 * $point)+(70/100 * $donate); @endphp
						<td class="author">{{$sum}} point</td>
						@elseif($item->type_author == 'unofficial')
							@php $sum = (40/100 * $point)+(50/100 * $donate); @endphp
						<td class="author">{{$sum}} point</td>
						@elseif($item->type_author == 'unrestrained')
							@php $sum = $view/50; @endphp
						<td class="author">{{$sum}} point</td>
						@else
						<td class="author">0 point</td>
						@endif
						<td class="author">{{ $transfer_point }} point</td>
						<td class="author">
							<a href="{{ route('movedPointAdmin',['user_id'=>$item->id,'fromMonth'=>$startDate,'toMonth'=>$endDate]) }}" class="btn">{{ __('Chuyển point')}}</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		</form>
	</div>
@endsection