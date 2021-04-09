@extends('backend.layout.index')
@section('title','Yêu cầu ')
@section('content')
	@php
		$keyword = (isset($_GET["s"])) ? $_GET["s"] : '';
	@endphp
	<div id="cat-comics" class="page">
		<div class="head container">
			<h1 class="title">Yêu cầu</h1>
		</div>	
		<div class="main">
			<a href="{{ route('createWithdrawalAdmin') }}" class="btn btn-primary">Thêm mới</a>
			<div class="row search-filter">
				<div class="col-md-6 search-form pull-right">
					<form name="s" action="#" method="GET">
						<div class="s-key">
							<input type="text" name="s" class="form-control s-key" placeholder="Nhập từ khoá..." value="{{ $keyword }}">
						</div>
						<div class="form-group">
							
						<button type="submit" class="btn "><i class="fa fa-search" aria-hidden="true"></i></button>
						</div>
					</form>
				</div>
			</div>
			<form action="#" method="POST" class="dev-form" data-delete="{{ route('deleteAllWithdrawalAdmin') }}">
				{{ csrf_field() }}
				<div id="tb-result" class="table-responsive">
					<table class="table table-striped list">
						<thead class="thead-dark">
							<tr>
								@can('withdrawals.delete')
								<th id="check-all" class="check">
									<div class="checkbox checkbox-success">
										<input id="check" type="checkbox" name="checkAll[]" value="">
										<label for="check"></label>
									</div>
								</th>
								@endcan
								<th class="stt">{{ __('STT') }}</th>
								<th>{{ __('Ảnh xác nhận') }}</th>
								<th class="title">{{ __('Tiêu đề') }}</th>
								<th class="title">{{ __('Số point tác giả đang có') }}</th>
								<th class="title">{{ __('Số point yêu cầu') }}</th>
								<th class="title">{{ __('Tác giả') }}</th>
								<th class="title">{{ __('Người kiểm duyệt') }}</th>
								<th class="title">{{ __('Status') }}</th>
								@can('withdrawals.delete')
								<th class="action">{{ __('Tác vụ') }}</th>
								@endcan
							</tr>
						</thead>
						<tbody>
							@php
								$status = getStatusWithdrawals();
							@endphp
							@if($withdrawals->isNotEmpty())
								@foreach($withdrawals as $key => $item)
								@php
									$author = getNameByUser($item->author_id);
									$user = getNameByUser($item->user_id);
								@endphp
									<tr id="item-{{ $item->id }}">
										@can('withdrawals.delete')
										<td class="check">
											<div class="checkbox checkbox-success">
												<input id="withdrawals-{{ $item->id }}" type="checkbox" name="withdrawals[]" value="{{ $item->id }}">
												<label for="withdrawals-{{ $item->id }}"></label>
											</div>
										</td>
										@endcan
										<td>{{ $key + 1 }}</td> 
										<td>{!! image($item->image, 50, 50, $item->title) !!}</td>
										<td class="title"><a href="{{ route('editWithdrawalAdmin', $item->id) }}">{{ $item->title }}</a></td>
										<td>{!! $user->point != null ? $user->point : 0  !!}</td>
										<td>{{ $item->point }}</td>
										<td>{{ $user != null ? $user->name : 'NULL' }}</td>
										<td>{{ $author != null ? $author->name : 'NULL'}}</td>
										<td class="btn btn-status {{ $item->status == 'completed' ? 'btn-success' : 'btn-danger'}}">{{ $status[$item->status]}}</td>
										<td class="action">
											@can('withdrawals.update')
											<a href="{{ route('editWithdrawalAdmin', $item->id) }}" class="edit"><i class="fal fa-edit"></i></a>
											@endcan
											@can('withdrawals.delete')
											<a href="{{ route('deleteWithdrawalAdmin', $item->id) }}" class="delete btn-delete"><i class="fal fa-times"></i></a>
											@endcan
											@handheld<a href="javascript:void(0);" class="view"><i class="fal fa-eye"></i></a>@endhandheld
										</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
					@if(isset($keyword) && $keyword != "")
					    {{ $withdrawals->appends(['s'=>$keyword])->links() }}
					 @else
					    {{ $withdrawals->links() }}
					 @endif		
				</div>
			</form>
		</div>
	</div>
	
@endsection
