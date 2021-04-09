@extends('templates.master')
@section('title','Nạp tiền')
@section('content')
<div id="profile-payment" class="page profile payment">
	@include('members.profile_header')
	<div class="container">
		<div class="pro-wrap">
			<div id="pro-main" class="row">		
				<div class="main col-md-9">
					<div class="main-wrap">
						<ul class="pro-menu">
							<li><span class="active">Phương thức thanh toán</span></li>
						</ul>					
						<div class="choose-type">						
							<div class="row list-packages">							
								<div class="col-md-6 col-sm-6 col-xs-6 item item-1">
									<div class="wrap">
										<figure class="image">
											<img src="{{asset('public/images/atm.png')}}" alt="icon">
										</figure>
										<div class="desc">
											<h3>Thanh toán bằng ATM</h3>
											<p>Ngân hàng ViệtNam</p>
										</div>
									</div>
									<div class="group-action">
										<a href="{{route('paymentTypeProfile',['payType'=>'atm'])}}" class="book bg-yellow">Chọn</a>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 item item-2">
									<div class="wrap">
										<figure class="image">
											<img src="{{asset('public/images/card-mobile.png')}}" alt="icon">
										</figure>
										<div class="desc">
											<h3>Thanh toán bằng thẻ cào</h3>
											<p>Thẻ cào: Mobi, Viettel, Vina...</p>
										</div>
									</div>
									<div class="group-action">
										<a href="{{route('paymentTypeProfile',['payType'=>'game-bank'])}}" class="book bg-red">Chọn</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="description">
						<p>Trải nghiệm ngay phương thức thanh toán mới tiện lợi bằng <span class="highlight">Đồng Tốt</span>.</p>						
					</div>	
				</div>
				<div class="sidebar col-md-3 sb-left">@include('sidebars.member')</div>
			</div>
		</div>
	</div>
</div>
@endsection