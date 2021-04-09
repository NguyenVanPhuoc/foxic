<table class="table table-striped list">
	<thead class="thead-dark">
		<tr>
			<th id="check-all" class="check">
				<div class="checkbox checkbox-success">
					<input id="check" type="checkbox" name="checkAll[]" value="">
					<label for="check"></label>
				</div>
			</th>
			<th class="stt">{{ __('STT') }}</th>
			<th class="title">{{ __('Tiêu đề') }}</th>
			<th class="text-center">{{ __('Loại thanh toán') }}</th>
			<th class="action">{{ __('Tác vụ') }}</th>
		</tr>
	</thead>
	<tbody>
		@if($payment->isNotEmpty())
			@foreach($payment as $key => $item)
				@if($item->pay_id)
					@php 
						$cat = get_categories_payment($item->pay_id); 
					@endphp
				@endif
				<tr id="item-{{ $item->id }}">
					<td class="check">
						<div class="checkbox checkbox-success">
							<input id="payment-{{ $item->id }}" type="checkbox" name="payment[]" value="{{ $item->id }}">
							<label for="payment-{{ $item->id }}"></label>
						</div>
					</td>
					<td>{{ $key + 1 }}</td>
					<td class="title"><a href="{{ route('editPaymentAdmin', $item->id) }}">{{ $item->title }}</a></td>
					<td class="text-center">{!! $cat->title !!}</td>
					<td class="action">
						<a href="{{ route('editPaymentAdmin', $item->id) }}" class="edit"><i class="fal fa-edit"></i></a>
						<a href="{{ route('deletePaymentAdmin', $item->id) }}" class="delete btn-delete"><i class="fal fa-times"></i></a>
						@handheld<a href="javascript:void(0);" class="view"><i class="fal fa-eye"></i></a>@endhandheld
					</td>
				</tr>
			@endforeach
		@endif
	</tbody>
</table>
@if(isset($keyword) && $keyword != "")
    {{ $payment->appends(['s'=>$keyword])->links() }}
 @else
    {{ $payment->links() }}
 @endif