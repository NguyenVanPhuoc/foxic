$(document ).ready(function(){
	$('#product .add-cart').click(function(e){
		e.preventDefault();
		var _token = $('input[name=_token]').val();
		var link = $('input[name=actionAddCart]').val();
		var id = $('#product').attr('data-id');
		var qty = $('input[name=quantity]').val();

		$('#overlay').show();
		$('.loading').show();
		$.ajax({
            type:'POST',
            url:link,
            cache: false,
            data:{
                '_token': _token,
                'id': id,
                'qty': qty
            },
        }).done(function(data) {
			$('.loading').hide();
            if(data.msg == "success"){
                $('header .gr-right-fixed .cart .cart-qty').text(data.total_qty);
                $('#cart-popup .total-price .price').html(data.total_price);
               	$('#cart-popup').fadeIn();
                
            }
            else{
                new PNotify({
                    title: 'Lỗi',
                    text: 'Hệ thống đang có sự cố. Vui lòng thử lại sau.',
                    type: 'error',
                    hide: true,
                    delay: 2000,
                });
            }
        });
    });
    if($('.page .list-cat').length){
        $('.list-cat .list-item li.has-child > a').prepend('<span class="open-sub"><i class="fas fa-angle-right"></i></span>');
        $('.list-cat .sub-menu .item').each(function(){
            if($(this).hasClass('active')){
                $(this).closest('.has-child').addClass('active');
            }
        });
    }
});