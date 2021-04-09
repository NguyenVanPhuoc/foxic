$(document ).ready(function(){	
	$('#payment-method .payment-method .btn').click(function(e){
		e.preventDefault();
		var _token = $('input[name=_token]').val();
		var link = $(this).attr('href');
		var month = $('input[name=month]').val();
		var total_price = $('input[name=total_price]').val();
		$.ajax({
			type:'POST',
			url:link,
			cache: false,
			data:{
				'_token': _token,
				'month': month,
				'total_price': total_price,
			},
			success:function(data){ console.log(data.msg);
				if(data.msg != undefined && data.msg == 'success')
					window.location.href = data.redirect;
			}
		});
	});
});