@php $count = 1; $type = empty($_GET["type"])? 'news' : $_GET["type"]@endphp
<table id="card-transactions" class="table table-striped list">
	<thead class="thead-dark">
		<tr>
			<th class="stt">STT</th>
			<th class="transaction-id">Mã giao dịch</th>
			<th class="pin hidden-600">Pin</th>
			<th class="seri hidden-600">Seri</th>
			<th class="card-type">Loại thẻ</th>
			<th class="info-card hidden-480">Mệnh giá</th>
			<th class="time hidden-768">Ngày nạp</th>
			<th class="msg hidden-1024">Trạng thái</th>
			<th class="member hidden-736">Thành viên</th>
			<th class="action">Tác vụ</th>
		</tr>
	</thead>
	<tbody>
		@foreach($transactions as $item)
		<tr id="item-{{ $item->id }}">
			<td class="stt">{{$count++}}</td>
			<td class="transaction-id">{{ $item->transaction_id }}</td>
			<td class="pin hidden-600">{{ $item->pin }}</td>
			<td class="seri hidden-600">{{ $item->seri }}</th>
			<th class="card-type hidden-480">{{ cardType($item->card_type) }}</td>
			<td class="info-card">{!! currency($item->price_guest) !!}</td>
			<td class="time hidden-768">{{$item->created_at}}</td>
			<td class="msg hidden-1024">{{ $item->msg }}</td>
			<td class="member hidden-736"><a href="{{ route('editAdmin',['id'=>$item->user_id]) }}">{{$item->username}}</a></td>
			<td class="action">
				<a href="{{route('deleteTransactionAdmin',['type'=>$type,'id'=>$item->id])}}" class="delete"><i class="fa fa-close" aria-hidden="true"></i></a>
				@handheld<a href="javascript:void(0);" class="view"><i class="fa fa-eye" aria-hidden="true"></i></a>@endhandheld
			</td>
		</tr>
			@handheld
				<tr class="item-{{ $item->id }} info-detail">
					<td colspan="10">
						<div class="box">
							<ul class="list-unstyled">
								<li>Mã giao dịch: <strong>{{ $item->transaction_id }}</strong></li>
								<li>Pin: <strong>{{ $item->pin }}</strong></li>
								<li>Seri: <strong>{{ $item->seri }}</strong></li>
								<li>Loại thẻ: <strong>{{ cardType($item->card_type) }}</strong></li>
								<li>Mệnh giá: <strong>{!! currency($item->price_guest) !!}</strong></li>
								<li>Ngày nạp: <strong>{{ $item->created_at }}</strong></li>
								<li>Trạng thái: <strong>{{ $item->msg }}</strong></li>
								<li>Thành viên: <strong><a href="{{ route('editAdmin',['id'=>$item->user_id]) }}">{{ $item->username }}</a></strong></li>
							</ul>
						</div>
					</td>
				</tr>
			@endhandheld
		@endforeach
	</tbody>
</table>