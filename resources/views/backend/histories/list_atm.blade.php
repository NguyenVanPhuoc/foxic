@php $count = 1; $type = empty($_GET["type"])? 'news' : $_GET["type"]@endphp
<table id="atm-transactions" class="table table-striped list">
	<thead class="thead-dark">
		<tr>
			<th class="stt">STT</th>
			<th class="transaction-id">Mã giao dịch</th>
			<th class="amount">Số tiền</th>
			<th class="note hidden-480">Nội dung</th>
			<th class="time hidden-768">Ngày nạp</th>
			<th class="msg hidden-768">Trạng thái</th>
			<th class="member hidden-736">Thành viên</th>
			<th class="action">Tác vụ</th>
		</tr>
	</thead>
	<tbody>
		@foreach($transactions as $item)
		<tr id="item-{{ $item->id }}">
			<td class="stt">{{$count++}}</td>
			<td class="transaction-id">{{ $item->transaction_id }}</td>
			<th class="amount">{!! currency($item->amount) !!}</td>
			<td class="note hidden-480">{{ $item->note }}</td>
			<td class="time hidden-768">{{ $item->created_at }}</td>
			<td class="msg hidden-768">{{ $item->status }}</td>
			<td class="member hidden-736"><a href="{{ route('editAdmin',['id'=>$item->user_id]) }}">{{ $item->username }}</a></td>
			<td class="action">
				<a href="{{ route('deleteTransactionAdmin',['type'=>$type,'id'=>$item->id]) }}" class="delete"><i class="fa fa-close" aria-hidden="true"></i></a>
				@handheld<a href="javascript:void(0);" class="view"><i class="fa fa-eye" aria-hidden="true"></i></a>@endhandheld
			</td>
		</tr>
			@handheld
				<tr class="item-{{ $item->id }} info-detail">
					<td colspan="8">
						<div class="box">
							<ul class="list-unstyled">
								<li>Mã giao dịch: <strong>{{ $item->transaction_id }}</strong></li>
								<li>Số tiền: <strong>{!! currency($item->amount) !!}</strong></li>
								<li>Nội dung: <strong>{{ $item->note }}</strong></li>
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