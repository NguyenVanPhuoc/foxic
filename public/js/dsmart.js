function createCookie(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
}

$(document).ready(function(){
	if($('.star-rating .rate').length > 0) {
		var readonly =  $('.star-rating .rate').attr('data-readonly');
		if(readonly == 1) readonly = true;
		else readonly = false;
		$('.star-rating .rate').raty({
			path: '/public/js/img/',
			readOnly: readonly,
	  		half:  true,
	  		number: 5,
	  		start: parseFloat($('.star-rating .rate').attr('data-rate')),
	  		target: '#hint',
	  		hintList:['Tạm', 'Cũng được', 'Được', 'Hay', 'Tuyệt đỉnh'],
	  		click: function(e){
	  			var ajaxUrl = $(this).parents('#content').attr('data-url');
	  			var comic_id = $(this).attr('data-id');
	  			var rate = $(this).find('input[name="score"]').val();
	  			var _token = $("input[name='_token']").val();
	  			$.ajax({
            		type: "POST",
            		url: ajaxUrl,
            		data: {
	                    'id': comic_id,
	                    'rate': rate,
	                    '_token': _token,
	                },
        		}).done(function(data) {
        			alert('Cám ơn bạn đã đánh giá truyện!');
        			location.reload();
        		});
	  		}
		});
	};
	$('#chap-page .chap-comment').on('click', function(e) {
		e.preventDefault();
		$('#chap-page .comments').slideToggle();
	});
	$('#chap-page .s-list').on('click', function(e) {
		e.preventDefault();
		$('#chap-page .chap-nav').addClass('active');
	});
	$('#chap-page').on('change','.chap-nav .select-chap',function() {
		var url = $(this).val();
		window.location.href = url;
	});
	// Acion when press WASD on #chap-page
	if($('#chap-page').length > 0) {
		$(document).on("keydown", function(e) {
	       	if (e.keyCode == 83) { 
	           	var top = $(window).scrollTop();
	           	if (top < $('document, body').height()) {
	           		$('html, body').animate({
		                scrollTop: top + 100
		            }, 25);
		            return false; 
	           	}	                       
	       	};
	       	if (e.keyCode == 87) { 
	           	var top = $(window).scrollTop();
	            if (top > 0) {
	           		$('html, body').animate({
		                scrollTop: top - 100
		            }, 25);
		            return false; 
	           	}            
	       	};
	       	if (e.keyCode == 37 && !$('.chap-nav .prev').hasClass('disabled')) {
	       		window.location.href = $('.chap-nav .prev').attr('href');
	       	};
	       	if (e.keyCode == 39 && !$('.chap-nav .next').hasClass('disabled')) {
	       		window.location.href = $('.chap-nav .next').attr('href');
	       	};
	       	if (e.keyCode == 65 && !$('.chap-nav .prev').hasClass('disabled')) {
	       		window.location.href = $('.chap-nav .prev').attr('href');
	       	};
	       	if (e.keyCode == 68 && !$('.chap-nav .next').hasClass('disabled')) {
	       		window.location.href = $('.chap-nav .next').attr('href');
	       	};
	  	});
	};
	if($('#chap-setting').length > 0) {
		var ajaxUrl = $('#form-setting').attr('data-action');
		var _token = $("input[name='_token']").val();
		$('#form-setting select').on('change',function() {
			var attr = $(this).attr('data-style');
			var ck = $(this).attr('data-ck');
			var value = $(this).val();
				
			if(attr == 'background-color') {
				var array = value.split('__');
				$('#chap-page').css({"background-color": '"'+array[0]+'"',"color": '"'+array[1]+'"'});
				$('body').removeClass('dark-theme');
			}else{
				$('#chap-page .page-content .chap-detail').css(attr,value);
			};
			$.ajax({
	            type:'POST',            
	            url: ajaxUrl,
	            cache: false,
	            data:{
	                'attr': ck,
	                'value': value,
	                '_token': _token,
	            },
	            success:function(data){    	
	            }
	        });
		});
		$('#form-setting select').on('change',function() {
			var attr = $(this).attr('data-style');
			var ck = $(this).attr('data-ck');
			var value = $(this).val();
			if(attr == 'font-family') {
					$('.chap-detail').css({"font-family": value});
	        }
			$.ajax({
	            type:'POST',            
	            url: ajaxUrl,
	            cache: false,
	            data:{
	                'attr': ck,
	                'value': value,
	                '_token': _token,
	            },
	            success:function(data){    	
	            }
	        });
		});
		$('#form-setting input[name="frm_fluid"]').on('change',function() {
			var attr = 'frm_fluid';
			var value = $(this).val();
			if(value == 'yes') {
				$('#chap-page .page-content').addClass('container-fluid').removeClass('container');
			}else{
				$('#chap-page .page-content').removeClass('container-fluid').addClass('container');
			};
			$.ajax({
	            type:'POST',            
	            url: ajaxUrl,
	            cache: false,
	            data:{
	                'attr': attr,
	                'value': value,
	                '_token': _token,
	            },
	            success:function(data){    	
	            }
	        });
		});
		$('#form-setting input[name="frm_break"]').on('change',function() {
			var value = $(this).val();
			var attr = 'frm_break';
			if(value == 'yes') {	
				$('br').each(function () {
				    if ($(this).next().is('br')) {
				        $(this).next().remove();
				    }
				});
			}else{
				$("#chap-page .chap-detail br").after("<br>");
			};
			$.ajax({
	            type:'POST',            
	            url: ajaxUrl,
	            cache: false,
	            data:{
	                'attr': attr,
	                'value': value,
	                '_token': _token,
	            },
	            success:function(data){    	
	            }
	        });
		});

		
	};
	if($('.toggle-nav').length >0) {
		$('.toggle-nav').on('click', function() {
			$('header').slideToggle();
			$(this).toggleClass('active');
		});
	};
	$('#chap-page .chap-error').on('click', function() {
		var data = prompt("Vui lòng mô tả lỗi", "");
		if(data != null && data != '')  {
			alert('Cám ơn bạn đã báo nha!');
			$(this).remove();
		};			
	});
	/*
	* Load Search Ajax
	*/
	$('header #form-seach input[type=text]').on('input', function(){
	   	clearTimeout(this.delay);
	   	this.delay = setTimeout(function(){	      	
	      	var keyword = this.value;
	      	if (keyword.length > 2) {
	      		var ajaxUrl = $('#search-res').attr('data-href');	      		
	      		var _token = $("input[name='_token']").val();
	      		$.ajax({
		            type:'POST',            
		            url: ajaxUrl,
		            cache: false,
		            data:{
		                'keyword': keyword,
		                '_token': _token,
		            },
		            beforeSend: function() {
		            	$('header #search-res .results').html('');
		            	$('header #search-res .search-load').show();
		            	$('header #search-res').show();
		            },
		            success:function(data){
	            		$('header #search-res .search-load').hide();
	            		$('header #search-res .results').html(data);       	
		            }
		        });
	      	}else{
	      		$('header #search-res').hide();
	      	}	      	
	   	}.bind(this), 1000);
	});
	if($('#form-setting-home').length > 0) {
		$('#form-setting-home select').on('change',function() {
			var value = $(this).val();
			console.log(value);
			$('body').removeClass("dark-theme").removeClass("light-theme").addClass(value);
			createCookie('themeStyle',value,30);
			if(value == "dark-theme"){
				$(".fb-comments").css("filter","invert(1) hue-rotate(165deg) saturate(70%)");
			}else{
				$(".fb-comments").css("filter","none");
			}
		});	
	}
	if($('.pages .short-desc').length > 0){
		$('.pages .summary').on('click', '.view_more', function(e){
			e.preventDefault();
			$(this).parents('.pages').find('.short-desc').addClass('open');
			$(this).hide();
		})
	}
})
