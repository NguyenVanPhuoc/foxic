<div style="max-width: 540px; padding:10px 50px; margin:0 auto; font-size: 15px; line-height: 21px;">
	<h2 style="font-size: 17px; margin-bottom: 0">Thông báo!</h2>
	<p>Hệ thống vừa nhận được yêu cầu chuyển <strong>{{$data['packageName']}}</strong> của chủ hàng <strong>{{$data['name']}}</strong>, thông tin đơn hàng như sau:</p>	
	{!!$data['message']!!}
	<div style="padding-top:20px;">{!!address()!!}</div>
</div>