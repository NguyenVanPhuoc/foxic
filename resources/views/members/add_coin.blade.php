@extends('templates.master')
@section('title','Nạp xu')
@section('content')
	<div class="payment content-coin">
		<div class="wrapper-coin">
			<div class="container">
				@include('members.coin_header')
				@include('members.menu_coin')
				<div class="content-tabs">
					<form action="{{ route('onlinePayment') }}" method="POST" id="online-payment">
						{{csrf_token()}}
						<div class="purchase-list">
							<h5 class="title-h5">{{ __('Chọn phương thức thanh toán')}}</h5>
							@if(isset($cate))
							@php
								$title = '';
								$promotion = '';
								$basic = '';
							@endphp
							<div class="list-method list">
								@foreach($cate as $key => $item)
									<div class="item check-radio cat_{{$item->id}}">
										<label for="radio{{$item->id}}">
											<input type="radio" name="method" id="radio{{$item->id}}" class="check" data-id="{{$item->id}}" {{ $key == 0 ? 'checked' : '' }}>
											<span>{{ $item->title}}{!! imageAuto($item->image,$item->title) !!}</span>
										</label>
									</div>
									@php
										$title .= '<h5 class="title title'.$item->id;
										if($key != 0){
											$title .= ' hidden';
										}
										$title .= '">'.$item->title.'</h5>';
										$list_promotion = getListPaymentInPayid($item->id);
										$promotion .= '<div class="coin-list list check'.$item->id;
										if($key != 0){
											$promotion .= ' hidden';
										}
										$promotion .= '">';
											$promotion .= '<div class="font-bold head-pack"><span>Gói khuyến mãi</span></div>';
											foreach($list_promotion as $pro){
												$promotion .= '<div class="item check-radio">';
													$promotion .= '<label for="radio_pay'.$pro->id.'">';
														$promotion .= '<input type="radio" name="payment" id="radio_pay'.$pro->id.'">';
														$promotion .= '<span>'.$pro->title.'</span>';
													$promotion .= '</label>';
													$promotion .= '<p class="money">'.$pro->amount.'đ'.'</p>';
												$promotion .= '</div>';	
											}
										$promotion .= '</div>';	
										$list_basic = getListPaymentInPayidV1($item->id);
										$basic .= '<div class="coin-list list check'.$item->id;
										if($key != 0){
											$basic .= ' hidden';
										}
										$basic .= '">';
											$basic .= '<div class="font-bold head-pack"><span>Gói cơ bản</span></div>';
											foreach($list_basic as $value){
												$basic .= '<div class="item check-radio">';
													$basic .= '<label for="radio_pay'.$value->id.'">';
														$basic .= '<input type="radio" name="payment" id="radio_pay'.$value->id.'">';
														$basic .= '<span>'.$value->title.'</span>';
													$basic .= '</label>';
													$basic .= '<p class="money">'.$pro->amount.'đ'.'</p>';
												$basic .= '</div>';	
											}
										$basic .= '</div>';	
									@endphp
								@endforeach
								<div class="item check-radio cat_sms">
									<label for="radio_10">
										<input type="radio" name="method" id="radio_10" class="check" data-id="10">
										<span>{{ __('Thanh toán bằng SMS')}}<img src="{{ asset('public/images/icons/img-sms.png') }}" alt="facebook"></span>
									</label>
								</div>
							</div>
							@endif
						</div>
						<div class="purchase-list">
							{!! $title !!}
							{!! $promotion !!}
							{!! $basic !!}
							<h5 class="title title10 hidden">{{ __('Thanh toán bằng SMS (Mobifone, Viettel, Vinaphone)')}} </h5>
							<div class="coin-list list check10 hidden">
								<div class="item sms">
									<span class="add">Nạp <span class="font-bold red">10.000 đ</span> được 38 xu</span>
									<span class="syntax"><span class="btn btn-primary">Soạn tin</span>CMC <span class="font-bold red">&lt;UserID&gt;</span> <span class="send">gửi</span> 8679</span>
								</div>
								<div class="item sms">
									<span class="add">Nạp <span class="font-bold red">15.000 đ</span> được 57 xu</span>
									<span class="syntax"><span class="btn btn-primary">Soạn tin</span>CMC <span class="font-bold red">&lt;UserID&gt;</span> <span class="send">gửi</span> 8679</span>
								</div>
							</div>
						</div>
						<button type="submit" class="btn-red btn">{{ __('Xác nhận')}}</button>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection