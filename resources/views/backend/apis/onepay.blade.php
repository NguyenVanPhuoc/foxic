@extends('backend.layout.index')
@section('title','Onepay config')
@section('content')
@php $coins = getCoins('onepay'); @endphp
<div id="onepay-api" class="page p-api">
	<div class="head container">
		<h1 class="title">Onepay API</h1>		
	</div>	
	<div class="main">
		<form action="{{route('editAPIAdmin',['type'=>'onepay'])}}" method="POST" name="blog" class="dev-form">
			{!!csrf_field()!!}
			<div class="api-info">
				<div class="left-box clearfix">
					<div class="wrap">
						<h3 class="title-h3">Thông số kết nối</h3>
						<div class="row">
							<div class="col-md-6">
								<h4>Cổng thanh toán Nội địa</h4>
								<div id="frm-merchant-in" class="form-group">
									<label for="">MerchantID<small class="required">*</small></label>
									<input type="text" name="merchant_in" class="form-control" value="{{$options->onepay_in_merchantID}}">
								</div>
								<div id="frm-secret-in" class="form-group">
									<label for="">Secure Secret<small class="required">*</small></label>
									<input type="text" name="secret_in" class="form-control" value="{{$options->onepay_in_secureSecret}}">
								</div>
								<div id="frm-code-in" class="form-group">
									<label for="">Access Code<small class="required">*</small></label>
									<input type="text" name="code_in" class="form-control" value="{{$options->onepay_in_accessCode}}">
								</div>
							</div>
							<div class="col-md-6">
								<h4>Cổng thanh toán Quốc tế</h4>
								<div id="frm-merchant-out" class="form-group">
									<label for="">MerchantID<small class="required">*</small></label>
									<input type="text" name="merchant_out" class="form-control" value="{{$options->onepay_out_merchantID}}">
								</div>
								<div id="frm-secret-out" class="form-group">
									<label for="">Secure Secret<small class="required">*</small></label>
									<input type="text" name="secret_out" class="form-control" value="{{$options->onepay_out_secureSecret}}">
								</div>
								<div id="frm-code-out" class="form-group">
									<label for="">Access Code<small class="required">*</small></label>
									<input type="text" name="code_out" class="form-control" value="{{$options->onepay_out_accessCode}}">
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
			<div class="group-action"><button type="submit" class="btn">Sửa</button></div>
		</form>
	</div>
</div>
<script type="text/javascript">
	$(function() {
		
		$("#onepay-api").on('click','form .group-action button',function(e){
			e.preventDefault();
			var _token = $("form input[name='_token']").val();
			var merchant_in = $("#frm-merchant-in input").val();			
			var secret_in = $("#frm-secret-in input").val();			
			var code_in = $("#frm-code-in input").val();
			var merchant_out = $("#frm-merchant-out input").val();			
			var secret_out = $("#frm-secret-out input").val();			
			var code_out = $("#frm-code-out input").val();

           	var errors = new Array();		
			var error_count = 0;
			
			if(merchant_in == '')errors.push('Vui lòng nhập MerchantID (Cổng nội địa)');
			if(secret_in=="") errors.push('Vui lòng nhập Secure Secret (Cổng nội địa).');
			if(code_in=="") errors.push('Vui lòng nhập Access Code (Cổng nội địa).');
			if(merchant_out == '')errors.push('Vui lòng nhập MerchantID (Cổng nội quốc tế)');
			if(secret_out=="") errors.push('Vui lòng nhập Secure Secret (Cổng nội quốc tế).');
			if(code_out=="") errors.push('Vui lòng nhập Access Code (Cổng nội quốc tế).');	
			var i;
	   		var html = "<ul>";
	       	for(i = 0; i < errors.length; i++){
	       		if(errors[i] != ""){
	       			html +='<li>'+errors[i]+'</li>';
	       			error_count += 1;
	       		}
	       	}
	       	html += "</ul>";
			if(error_count>0){
				new PNotify({
					title: 'Lỗi dữ liệu ('+error_count+')',
					text: html,						    
					hide: true,
					delay: 6000,
				});
			}else{				
				$(".dev-form").append('<img class="loading" src="'+location.protocol + "//" + location.host+'/public/images/loading_red.gif" alt="loadding..."/>');
				$.ajax({
					type:'POST',            
					url:$('.dev-form').attr('action'),
					cache: false,
					data:{
						'_token': _token,
						'merchant_in': merchant_in,
						'secret_in': secret_in,
						'code_in': code_in,
						'merchant_out': merchant_out,
						'secret_out': secret_out,
						'code_out': code_out,
					},
				}).done(function(data) { 
					$(".dev-form .loading").remove();
					if(data.message=="success"){
						new PNotify({
							title: 'Thành công',
							text: 'Cập nhật thành công.',
							type: 'success',
							hide: true,
							delay: 2000,
						});
					}
				});
			}
			return false;
		});
	});	
</script>
@stop