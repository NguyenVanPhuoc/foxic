$(document).ready(function(){
	$('.open-reply-form').on('click', function(e) {
		e.preventDefault();
		$(this).parent().siblings('.form-reply-comment').slideToggle();
		$('.form-reply-comment').not($(this).parent().siblings('.form-reply-comment')).slideUp();
	});

	$('.comments').on('click', '.form-reply-comment button', function(e) {
		e.preventDefault();
		var itemCMT = $(this).closest('.item-cmt');
		var action = $(this).closest('form').attr('data-action');
		var content = $(this).closest('form').find('.frm_content').val();
		var _token = $("input[name='_token']").val();
		if(content != '') {
			$.ajax({
	            type:'POST',
	            url: action,
	            cache: false,
	            dataType: 'json',
	            data:{
	                '_token': _token,
	                'content': content
	            },
	        }).done(function(data) {
	            if(data.check == 'true') {
	            	itemCMT.find('.list-replies').prepend(data.html);
	            	itemCMT.find('.form-reply-comment').hide();
	            }else{
	            	alert(data.messages);
	            }
	        });
		}else{
			alert('Vui lòng nhập nội dung bình luận!');
		}
	});
	$('.loadMore .load_more').on('click', function(e) {
		e.preventDefault();
		var current = $(this).siblings('input[name="current_page"]').val();
		var action = $(this).attr('data-action');
		var _token = $("input[name='_token']").val();
		var currently = $(this);
		if(current != '') {
			$.ajax({
	            type:'POST',
	            url: action,
	            cache: false,
	            dataType: 'json',
	            data:{
	                '_token': _token,
	                'current': current
	            },
	            beforeSend: function( xhr ) {
	            	currently.prepend('<i class="fa fa-spinner fa-pulse" aria-hidden="true"></i>');
			  	},
                success:function(data) {
                	if(data.check == 'true') {
                		currently.closest('.list-comments').find('.list-item').append(data.html);
	            		currently.find('i.fa-spinner').remove();
	            		if(data.has_load) currently.siblings('input[name="current_page"]').val(parseInt(current) + 1);
	            			else currently.remove();
                	}else{
                		currently.remove();
                	}                  
                }
            });
		}
	});

	// Stickers
	$('.show_sticker').on('click', function(e) {
		e.preventDefault();
		$(this).closest('form').find('.list-packages').slideToggle();
	});

	$('body').on('click', '.list-packages .package-btn', function(e) {
		e.preventDefault();
		$('.list-stickers').not($(this).siblings('.list-stickers')).hide();
		$(this).siblings('.list-stickers').slideToggle();
	});

	$('#form-comment .choose-sticker').on('click', function(e) {
		e.preventDefault();
		var id = $(this).attr('href');
		$(this).closest('form').find('textarea').val(id);
		$(this).closest('form').find('input[name="type"]').val('sticker');
		$(this).closest('form').submit();
	});

	$('.form-reply-comment .choose-sticker').on('click', function(e) {
		e.preventDefault();
		var id = $(this).attr('href');
		var itemCMT = $(this).closest('.item-cmt');
		var action = $(this).closest('form').attr('data-action');	
		var _token = $("input[name='_token']").val();
		if(content != '') {
			$.ajax({
	            type:'POST',
	            url: action,
	            cache: false,
	            dataType: 'json',
	            data:{
	                '_token': _token,
	                'content': id,
	                'type': 'sticker',
	            },
	        }).done(function(data) {
	            itemCMT.find('.list-packages').hide();
	            if(data.check == 'true') {
	            	itemCMT.find('.list-replies').prepend(data.html);
	            	itemCMT.find('.form-reply-comment').hide();
	            }else{
	            	alert(data.messages);
	            }
	        });
		}else{
			alert('Vui lòng nhập nội dung bình luận!');
		}
	});

	$('body').on('click', '.edit_cmt', function(e) {
		e.preventDefault();
		var link = $(this).attr('href');
		var _token = $("input[name='_token']").val();
		$.ajax({
            type:'POST',
            url: link,
            cache: false,
            dataType: 'json',
            data:{
                '_token': _token,
            },
        }).done(function(data) {
        	if(data.check == 'true') {
        		$('#editComment .modal-body').html(data.html);
        		$('#editComment').modal('show');
        	}else alert(data.messages);
        });
	});

	$('body').on('change', '#editComment input[name="cmt_type"]',  function(e) {
		if($(this).val() == 'sticker') {
			$('#editComment .comment__sticker .list-stickers').hide();
			$('#editComment .comment__sticker').removeClass('not-show');
			$('#editComment .comment__content').addClass('not-show');
		}else{
			$('#editComment .comment__sticker').addClass('not-show');
			$('#editComment .comment__content').removeClass('not-show');
		}
	});

	$('body').on('click', '#editComment .choose-sticker',  function(e) {
		e.preventDefault();
		var id = $(this).attr('href');
		var img = $(this).html();
		$('#editComment input[name="sticker_cmt"]').val(id);
		$(this).closest('.list-packages').siblings('.current_sticker').html(img);
		$(this).closest('.list-stickers').hide();
	});

	$('body').on('click', '.edit_comment .delete_cmt', function(e){
        e.preventDefault();
        $(".modal-del-comment form").attr("action",$(this).attr("href"));
        $('.modal-del-comment').modal('show');
    });
})