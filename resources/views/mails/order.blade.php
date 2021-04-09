<div style="padding:10px 50px; margin:0 auto; font-size: 15px; line-height: 21px;">
	<p>Chào <strong>{{$data['name']}}</strong></p>
	<p>Cảm ơn bạn đã đặt hàng trên hệ thống. Chúng tôi xin xác nhận lại thông tin đơn hàng như sau:</p>	
	{!!$data['content']!!}
	
	<p>Mọi thắc mắc xin liên hệ : </p>
	<div style="padding-top:20px;">{!!address()!!}</div>
</div>