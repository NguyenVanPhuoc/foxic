$(document ).ready(function(){
	$(".bell").on('click', '.toggle-bell', function() {
        $(this).siblings('.dropdown-bell').addClass('show');
    });
    $(document).mouseup(function(e) {
        var container = $(".bell");
        if (!container.is(e.target) && container.has(e.target).length === 0 ) 
        {    
            $(".bell .dropdown-bell").removeClass('show');
        }
    });
	flatpickr(".date-flatpickr", {   
        dateFormat: "Y-m",
        static: true,
  		altInput: true,
  		disableMobile: "true",
  		plugins: [
	        new monthSelectPlugin({
	          shorthand: true, //defaults to false
	          dateFormat: "Y-m", //defaults to "F Y"
	          altFormat: "F Y", //defaults to "F Y"
	          theme: "dark" // defaults to "light"
	        })
	    ],
	    locale: {
            months: {
              shorthand: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
              longhand: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            },
          },    
    });
	/*flatpickr("#zxc", {
		dateFormat: "Y-m",
		enableTime: false,
	});*/
	// check roles	
	$('.toggle-cs').on('click', function(e) {
		e.preventDefault();
		$(this).closest('.list-item').find('.list-child').slideToggle();
	});
	if($('.check__checkbox_all').length > 0) {
		$('.check__checkbox_all').each(function() {
			var count = $(this).find('.list-child input[type="checkbox"]').length;
			var check = $(this).find('.list-child input[type="checkbox"]:checked').length;
			if(count == check) $(this).find('.parent-check').prop('checked', true);
		});
	}
	$('.check__checkbox_all .parent-check').on('change', function() {
		if($(this).prop('checked')) {
			$(this).closest('.check__checkbox_all').find('.list-child input[type="checkbox"]').prop('checked', true);
		}else{
			$(this).closest('.check__checkbox_all').find('.list-child input[type="checkbox"]').prop('checked', false);
		}
	});
	$('.check__checkbox_all .list-child input[type="checkbox"]').on('change', function() {
		var count = $(this).closest('.check__checkbox_all').find('.list-child input[type="checkbox"]').length;
		var check = $(this).closest('.check__checkbox_all').find('.list-child input[type="checkbox"]:checked').length;
		if(count == check) $(this).closest('.check__checkbox_all').find('.parent-check').prop('checked', true);
			else $(this).closest('.check__checkbox_all').find('.parent-check').prop('checked', false);
	});
	//end check roles
	$('.check-all').change(function(){
		if($('.check-all').is(':checked')){
			$(this).siblings('ul').find("input[type='checkbox']").prop('checked',true);
		}else{
			$(this).siblings('ul').find("input[type='checkbox']").prop('checked',false);
		}
	});
	$('.permissions input:not(.check-all)').change(function(){
		var $check_all = true,
			$zzz = $(this).closest('ul').siblings('input.check-all');
		$(this).closest('ul').find('input').each(function(){
			if(!$(this).is(':checked')) $check_all = false;
		})
		if($check_all == false){
			$zzz.prop('checked',false);
		}else{
			$zzz.prop('checked',true);
		}
	});
	$('.list-slide .add-row').click(function(e){
		e.preventDefault();
		var html = $('.att-temp .sortable').html();
		var number = $(this).parents('.list-slide').find('ul.sortable li').length + 1; 
		$('.list-slide ul.sortable').append(html);
		var item = $(this).parents('.list-slide').find('ul.sortable li:last-child');
		item.find(".img-upload").attr("id","img-"+number);
		item.attr("data-position",number);
	});
	//delete record   
    $(".sortable").on('click','i.fa-trash',function(){
        var recores = $(this).parents(".sortable-items").find(".sortable").attr("data-recores");
        var number = parseInt(recores) - 1;
        $(this).parents(".sortable-items").find(".sortable").attr("data-recores",number);	
        $(this).parents(".sortable .item").remove();
        var count = 0;
        $(".sortable .item").each(function(){
            count = count + 1;
            $(this).attr("data-position",count);
        });
    });
	
    //back to top
    $('body').append('<div id="backtotop"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i></div>');
        $(window).scroll(function() {
            if($(window).scrollTop() >200) {
              $('#backtotop').fadeIn();
              } else {
              $('#backtotop').fadeOut();
              }
            });
        $('#backtotop').click(function() {
        $('html, body').animate({scrollTop:0},500);
    });
	$('.scrollbar-inner').scrollbar();
	//empty search form
	$(".search-frm").on('click','.fa-close', function(){
		$(".search-frm .s").val("");
	});	
	$(".slug input").keyup(function(){	
		var title = $(this).val();
		if(title.length>0)
			$(this).val(convertToSlug(title));
		else
			$(this).val("");
	});	
	//show slug
	$(".slug").on('click','.btn-slug',function(){
		$(".slug").addClass("sl-active");
		$(this).addClass("sl-save");
		$(".slug .sl-save").text('Lưu');
		$(".slug .sl-save").after('<a href="#" class="sl-cancle">Hủy</a>');
		$(".slug input").prop("readonly",false);
		$(this).removeClass('btn-slug');
		return false;
	});
	//change slug
	$(".slug").on('click','.sl-cancle',function(){
		var slug = $(".slug input").attr("data-slug");
		$(".slug input").val(slug);
		$(".slug input").prop("readonly",true);
		$(".slug button").addClass('btn-slug');
		$(".slug button").addClass('sl-save');
		$(".slug").removeClass('sl-active');
		$(this).remove();
		return false;
	});
	//close slug
	$(".dev-form").on('click','.slug .sl-save',function(){		
		var _token = $(".dev-form input[name='_token']").val();
		var slug = $(".slug input").val();
		var link = $(".slug input").attr('data-action');
		if(slug==""){
			new PNotify({
			    title: 'Lỗi',
			    text: 'Slug không được rỗng!',
			    hide: true,
			    delay: 2000,
			});
		}else{
			$.ajax({
				type:'POST',
				url:link,
				cache: false,
				data:{
					'_token': _token,
					'slug': slug
				},
				success:function(data){
					$(".loading").hide();
					if(data!='error'){
						$(".slug .sl-cancle").remove();
						$(".slug input").val(data);
						$(".slug input").attr('data-slug',data);
						$(".slug button").addClass('btn-slug');
						$(".slug button").removeClass('sl-save');
						$(".slug button").text('Sửa');
						$(".slug").removeClass('sl-active');
						$(".slug input").prop("readonly",true);
					}
				}
			})
		}
		return false;
	});
	/**
	 * dell select item
	 */
	$("#check-all").click(function(){
		if($(this).find("input").is(":checked")){
			$(".dev-form tbody .check input").prop("checked", true);
			$(".dev-form .table").before('<button class="dell-all btn btn-top">Xóa</button>');
			$(".dev-form .table").after('<button class="dell-all btn btn-bottom">Xóa</button>');
		}else{			
			$(".dev-form .dell-all").remove();
			$(".dev-form tbody .check input").prop('checked', false);
		}
	})
	$(".dev-form tbody .check").click(function(){ 
		var items = new Array();
		$(".dev-form .dell-all").remove();
		$(".dev-form tbody tr").each(function(){
			if($(this).find(".check input").is(":checked")){
				items.push($(this).find("input").val());
			}
		});		
		if(items.length>0){
			$(".dev-form .table").before('<button class="dell-all btn btn-top">Xóa</button>');
			$(".dev-form .table").after('<button class="dell-all btn btn-bottom">Xóa</button>');
			if($(this).closest('form').find('.pagination').length){
				$('.dev-form .dell-all.btn-bottom').css('bottom', '35px');
			}
		}
	});
	//delete one item
  	$(document).on('click', '.dev-form .btn-delete', function(e){  
  		e.preventDefault();
  		var href = $(this).attr("href");
  		(new PNotify({
		    title: 'Delete',
		    text: 'Do you want delete?',
		    icon: 'glyphicon glyphicon-question-sign',
		    type: 'error',
		    hide: false,
		    confirm: {
		        confirm: true
		    },
		    buttons: {
		        closer: false,
		        sticker: false
		    },
		    history: {
		        history: false
		    }
		})).get().on('pnotify.confirm', function() {
		    window.location.href = href;
		});
		return false;
  	});
  	$('.dev-form .btn-delete').click(function(e){  
  		e.preventDefault();
  		var href = $(this).attr("href");
  		(new PNotify({
		    title: 'Delete',
		    text: 'Do you want delete?',
		    icon: 'glyphicon glyphicon-question-sign',
		    type: 'error',
		    hide: false,
		    confirm: {
		        confirm: true
		    },
		    buttons: {
		        closer: false,
		        sticker: false
		    },
		    history: {
		        history: false
		    }
		})).get().on('pnotify.confirm', function() {
		    window.location.href = href;
		});
		return false;
  	});
	//delete all
	$(".dev-form").on('click','.dell-all',function(){
  		var _token = $(this).parents("form").find("input[name='_token']").val();
  		var link = $(this).parents('form').attr('data-delete');
		var items = new Array();
		var tb_result = $(this).closest('#tb-result');
		$(".dev-form tbody tr").each(function(){
			if($(this).find(".check input").is(":checked")){
				items.push($(this).find("input").val());
			}
		});		
		if(items<0){
	       	new PNotify({
				title: 'Error',
				text: 'Please chose at least 1 row to delete',
				hide: true,
				delay: 6000,
			});
       	}else{
			PNotify.removeAll();
			(new PNotify({
			    title: 'Xoá',
			    text: 'Bạn có muốn xoá không?',
			    icon: 'glyphicon glyphicon-question-sign',
			    type: 'error',
			    hide: false,
			    confirm: {
			        confirm: true
			    },
			    buttons: {
			        closer: false,
			        sticker: false
			    },
			    history: {
			        history: false
			    }
			})).get().on('pnotify.confirm', function() {
				$('#overlay').show();
			    $(".loading").show();
				$.ajax({
					type:'POST',
					url: link,
					cache: false,
					data:{
						'_token': _token,
						'items': JSON.stringify(items)
					},
				}).done(function(data) { console.log(data.msg);
					$('#overlay').hide();
					$(".loading").hide();
					if(data.msg != undefined && data.msg == 'success'){
						tb_result.html(data.html);
						new PNotify({
							title: 'Thành công',
							text: 'Xoá thành công.',
							type: 'success',
							hide: true,
							delay: 2000,
						});
					}
					else if(data=="success"){
						$(".loading").hide();
						$(".dev-form tbody .check input").prop('checked', false);
						$.each(items, function(index, value){
							$(".dev-form #item-"+value).remove();
						});
						items = new Array();
						$(".dev-form .tb-results .dell-all").remove();
						new PNotify({
							title: 'Thành công',
							text: 'Xoá thành công.',
							type: 'success',
							hide: true,
							delay: 2000,
						});
					}else{
						new PNotify({
							title: 'Lỗi',
							text: 'Hệ thống đang gặp sự cố. Vui lòng thử lại sau.',
							hide: true,
							delay: 2000,
						});
					}
				});
			});
		}
		return false;
	});
	/**
	 * menu left
	 */
	$("#sidebar #menu .has-children").click(function(){
		var check = 0;
		if($(this).hasClass("active")){
			check = 1;
		}
		$("#sidebar #menu .has-children").removeClass('active');
		if(check==0){
			$(this).toggleClass("active");
		}	
	});
	//check change password
	$("#change-user .check-password .custom-control-input").click(function(){
		if($(this).is(":checked")){			
			$("#change-user .change-password .form-control").removeAttr("disabled");
			$("#change-user .change-password").slideDown();
			$(this).val("on");
		}else{
			$(this).val("");
			$("#change-user .change-password .form-control").attr("disabled","");
			$("#change-user .change-password").slideUp();
		}
	})

	$(".dev-form .action").on('click', '.delete', function(){
		var title = $(this).parents("tr").find(".title").text();
		var link = $(this).attr("href");
		$('.delete-modal .modal-footer .btn-primary').attr("href",link);
		$('.delete-modal .modal-body p').html("Bạn chắc là muốn xóa <strong>"+title+" ?</strong>");		
		$('.delete-modal').modal('toggle');
		return false;
	});
	
	/**
	 * library
	 */
	$(".dev-form").on('click','.library',function(){
		$("#library-op").removeClass('multi');
		$("#library-op #file-detail").empty();
		var _token = $(".dev-form input[name='_token']").val();
		var link = $(this).attr("href");
		var tag_id = $(this).parents(".img-upload").attr("id");
		var data_type = '';
		if($(this).parents(".img-upload").attr('data-type') != undefined)
			data_type = $(this).parents(".img-upload").attr('data-type');
		$("#library-op .modal-footer .btn-primary").attr("id",tag_id);
		$(".loading").show();
		$.ajax({
			type:'POST',
			url:link,
			cache: false,
			data:{
				'_token': _token,
				'data_type': data_type
			},
			success:function(data){
				$(".loading").hide();
				if(data.message!='error'){
					$('#library-op .modal-body #files .list-media').html(data.html);
					$("#library-op #files .limit").val(data.limit);
					$("#library-op #files .current").val(data.current);
					$("#library-op #files .total").val(data.total);

					$("#library-op").modal('toggle'); 
					
					$('#library-op .select2').select2({
						dropdownParent: $('#library-op')
					});
				}
			}
		})
		return false;	
	});
	//load more media	
	var total = 0;
	var current = 0;
	var limit = 0;	
	$("#library-op #files").scroll(function(){ 
		var _token = $(".dev-form input[name='_token']").val();
		var mediaCatId = $("#library-op #media-cat select").val();
		var s = $("#library-op #media-find input").val();
		var image_of = $('#library-op #image-of select').val();
		total = parseInt($("#library-op #files .total").val());
		current = parseInt($("#library-op #files .current").val());
		limit = $("#library-op #files .limit").val();		
		if(total>current){
			if($("#library-op #files").scrollTop() + $("#library-op #files").height()>= $("#library-op .list-media").height() + 10) {
				$.ajax({
					type:'POST',
					url:$("#library-op .more-media").val(),
					cache: false,
					data:{
						'_token': _token,
						'catId': mediaCatId,
						's': s,
						'image_of': image_of,
						'limit': $("#library-op #files .limit").val(),
						'current': $("#library-op #files .current").val(),
					},
					success:function(data){
						if(data!="error"){
							total = data.total;
							current = data.current
							$('#library-op .modal-body #files .list-media').append(data.html);
							$("#library-op #files .limit").val(data.limit);
							$("#library-op #files .current").val(data.current);
							$("#library-op #files .total").val(data.total);
						}
					}
				});
		    }
	    } 
	});

	$("#library-op .nav-tabs li").click(function(){
		$("#library-op .nav-tabs li").removeClass("active");
		$(this).addClass("active");
	});

	//change thumbnail
	$("#library-op .modal-footer").on('click','.btn-primary',function(){
		$("#library-op .modal-footer .library-notify").empty();
		var img_url = $("#library-op .modal-body li.active img").attr("src"); 
		var img_alt = $("#library-op .modal-body li.active img").attr("alt");
		var img_id;
		if( $(".list-media li.active").length){
			img_id = $(".list-media li.active").attr("id").split("-");
		} 
		var tag_id = $(this).attr("id"); 
		if(img_url === undefined){	
			$("#library-op .modal-footer .library-notify").text("Please chose media!!");
		}else{

			if(!$('#library-op').hasClass('multi')){ //old
				$(".dev-form #"+ tag_id+ " img").attr("src", img_url);
				$(".dev-form #"+ tag_id+ " .thumb-media").val(img_id[1]); 
				$("#library-op").modal('toggle');
				$(".modal-backdrop").modal('toggle');

				//if add pdf file
				if(tag_id == 'frm-pdf'){ 
					var file_name = $("#library-op .modal-body li.active img").attr("alt"); 
					var html = '';
					html += '<div class="wrap-pdf add">';
						html += '<img src="'+img_url+'" alt="pdf-icon"/>';
						html +='<h5>'+file_name+'</h5>';
						html += '<span class="remove-file">x</span>'
					html += '</div>';
					$(".dev-form #"+ tag_id).prepend(html);
					$(".dev-form #"+ tag_id +" .library").addClass('hide');
				}
				
			}
			else{//select multi
				var array_chose = $('#library-op input[name=array_chose]').val(); 
				var chosed = JSON.parse(array_chose);
				var html = '';
				var array_value = new Array();
				if($(".list-media li.active").length){

					for(var i=0; i<chosed.length; i++){
						var img_path = $('#image-'+chosed[i]+' img').attr('src'); 
						var img_title = $('#image-'+chosed[i]+' img').attr('data-title'); 
						//if have class 'sortable'
						var add_sortableClass = '';
						if($('#'+ tag_id).find('.sortable').length){
							add_sortableClass = ' ui-state-default';
						}
						html += '<div class="gallery-item item-'+ chosed[i] + add_sortableClass + '" data-id="'+ chosed[i] +'" >';
							html += '<div class="wrap-item">'
								html += '<img src="'+img_path+'" alt="image"/>';
								html += '<span class="remove-gallery">x</span>';
								html += '<span class="title">'+ img_title +'</span>';
							html += '</div>';
						html += '</div>';
					}
				}
				$(".dev-form #"+ tag_id+ " .wrap-gallery").append(html); 
				$('#' + tag_id +' .wrap-gallery .gallery-item').each(function(){
					array_value.push($(this).attr('data-id'));
				});
				$(".dev-form #"+ tag_id+ " .thumb-media").val(JSON.stringify(array_value));
				$("#library-op").modal('toggle');
			}
			
		}
		return false;
	});
	
	//detail media file
	$("#library-op.single .modal-body").on('click', '.list-media li', function(e){	
		e.preventDefault(); 
		if(!$(this).parents('#library-op').hasClass('multi')){ 
			$(".list-media li").removeClass("active");
			$(this).addClass('active');						
			var _token = $("#library-op #media input[name='_token']").val();
			var height = $("#library-op #files").height();
			$("#library-op .file-detail").css({'min-height':height});			
			$("#library-op .file-detail .wrap").append('<div class="loadding"><img src="'+location.protocol + "//" + location.host+'/public/images/loading_red.gif" alt="loadding..."/></div>');						
			$.ajax({
				type:'POST',
				url:location.protocol + "//" + location.host+'/admin/media/detail',
				cache: false,
				data:{
					'_token': _token,
					'id': $(this).attr("id")
				},
			}).done(function(data) {
				if(data.message=="success"){
					$("#library-op .file-detail .wrap").attr('data-id',data.file_id);
					$("#library-op .file-detail .wrap").html(data.html);
				}           		
			});
		}
		else{ 
			if(!$(this).hasClass('selected')){
				var img_id = $(this).attr("id").split("-");
				var array_chose = $('#library-op input[name=array_chose]').val(); 
				if($(this).hasClass('active')){
					$(this).removeClass('active');
					if(array_chose != ''){
						var chosed = JSON.parse(array_chose);
						var removeItem = img_id[1];
						chosed = jQuery.grep(chosed, function(value) {
					        return value != removeItem;
				      	});
				      	$('#library-op input[name=array_chose]').val(JSON.stringify(chosed));
					}
				}
				else{
					$(this).addClass('active');
					if(array_chose != ''){
						var chosed = JSON.parse(array_chose);
						chosed.push(img_id[1]);
						$('#library-op input[name=array_chose]').val(JSON.stringify(chosed)); 
					}
					else{
						$('#library-op input[name=array_chose]').val(JSON.stringify([img_id[1]]));
					}
				}
			}
		}	
		$(".list-media li").removeClass("view-detail");
		$(this).addClass('view-detail');
		var img_link = $(".list-media li.view-detail img").attr("data-image");
		var img_alt = $(".list-media li.view-detail img").attr("alt");
		var img_date = $(".list-media li.view-detail img").attr("data-date");
		var img_id = $(".list-media li.view-detail").attr("id").split("-");
		var html ="<div class='wrap'>";		
		html += "<h3>ATTACHMENT DETAILS</h3>";
		html += "<img src='"+img_link+"' alt='"+img_alt+"' />";
		html +="<h4>"+img_alt+"</h4>";
		html +="<p class='date'>"+img_date+"</p>";
		html +="<a href='#' class='delete' id='"+img_id[1]+"'>Xóa ảnh</a>";
		html +="</div>";
		$("#library-op #file-detail").html(html);
	});
	
	//delete media
	$("#library-op #file-detail").on('click', '.delete', function(){
		var _token = $("#library-op .tab-content #media input[name='_token']").val();
		var id = $(this).attr("id");
		var link = $("#library-op .tab-content #media form").attr("action");
		$.ajax({
			type:'POST',
			url:link,
			cache: false,
			data:{
				'_token': _token,
				'id': id
			},
			success:function(data){
				if(data!="error"){
					$("#library-op .modal-body #image-"+id).remove();
					$("#library-op #file-detail").empty();
					if(data!="success"){
						$("#avatar img").attr("src", data);
					}
				}
			}
		})
		return false;
	});

	/*
	* library gallery
	*/
	$(".dev-form").on('click','.library-gallery',function(){
		$("#library-op #file-detail").empty();
		$("#library-op .modal-footer .library-notify").empty();
		$('#library-op input[name=array_chose]').val('');
		$("#library-op").addClass('multi');
		var _token = $(".dev-form input[name='_token']").val();		
		var link = $(this).attr("href");
		var tag_id = $(this).parents(".img-upload").attr("id");			
		$("#library-op .modal-footer .btn-primary").attr("id",tag_id);
		$(".loadding").show();
		$.ajax({
			type:'POST', 
			url:link,
			cache: false,
			data:{
				'_token': _token
			},
			success:function(data){
				$(".loadding").hide();
				if(data.message!='error'){
					$('#library-op .modal-body #files .list-media').html(data.html);	
					$("#library-op #files .limit").val(data.limit);
					$("#library-op #files .current").val(data.current);
					$("#library-op #files .total").val(data.total);
					$("#library-op").modal('toggle');
					$('#library-op .select2').select2({
						dropdownParent: $('#library-op')
					});

					//check item selected
					if($('#' + tag_id + ' .wrap-gallery .gallery-item').length){
						$('#' + tag_id + ' .wrap-gallery .gallery-item').each(function(){
							var cr_id = $(this).attr('data-id');
							$('#library-op.multi #image-'+cr_id).addClass('selected');
						});
					}
				}
			}
		})
		return false;			
	});

	//remove image gallery
	$('.dev-form').on('click', '.wrap-gallery .gallery-item .remove-gallery', function(){ 
		var tag_id = $(this).parents(".img-upload").attr("id");	
		$(this).parents('.gallery-item').remove();
		if($('#'+ tag_id + ' .wrap-gallery .gallery-item').length){
			var array_value = new Array();
			$('#'+ tag_id +' .wrap-gallery .gallery-item').each(function(){
				array_value.push($(this).attr('data-id'));
			}); 
			$('#'+ tag_id +' .thumb-media').val(JSON.stringify(array_value));
		}
		else{
			$('#'+ tag_id +' thumb-media .wrap-gallery .thumb-media').val('');
		}
	});


	//view detail order
	$(".tb-results .action .view").click(function(){
		var id = $(this).attr("data-value");
		var check = 0;
		if($(".tb-results tbody .item-"+id).hasClass("active")){
			check = 1;
		}
		$(".tb-results tbody .detail").removeClass('active');
		if(check==0){
			$(".tb-results tbody .item-"+id).addClass("active");
		}
		return false;
	});
	//dropdown
	$(".local-dropdown .dropdown-menu .list-item a").click(function(){
		$(this).parents('.dropdown').find('.dropdown-toggle').text($(this).text());
		$(this).parents('.dropdown').find('.dropdown-toggle').attr("data-value",$(this).attr("data-value"));
		$(this).parents(".dropdown-menu").removeClass("show");
		return false;
	});

//vs-drop
	$('body').on('click', '.vs-drop .list-item a', function(e){ 
		e.preventDefault();
		$(this).parents(".vs-drop").find(".dropdown-toggle").attr("data-value",$(this).attr("data-value"));
		$(this).parents(".vs-drop").find(".dropdown-toggle").text($(this).text());
		if($(this).parents('.dropdown').find('input.value').length){ 
			$(this).parents('.dropdown').find('input.value').val($(this).attr("data-value"));
		}
		$(this).closest('.vs-drop').find('.dropdown-menu .list-item a').removeClass('active'); 
		$(this).addClass('active'); 
	});
	/**
	 * approve
	 */
	$(".frm-approve").on('click','.toggle',function(){
		var value = $(this).find("input").val();
		if(value==1){$(this).addClass("on")}
		$(this).toggleClass("on");
		if($(this).hasClass('on')){
			$(this).find("input").val(1);
		}else{
			$(this).find("input").val(0);
		}
	})
	//show notify
	$("header").on('click','.navbar-right .fa-bell',function(){		
		$("header .notifies").toggle();
	});
	$('.number-format').on('change','.txt-number', function (event) {
	    $(this).val(numberFormat($(this).val()));
	});
	/**
	*	packages
	*/
	$(".btn-renewal").click(function(){
        $(".article-op, .title-modal").remove();
        var id = $(this).attr("data-post");
        var title = $(this).parents("tr").find(".title").text();
        var img_url = $(this).parents("tr").find(".image a").attr("data-img");
        var html ='<div class="article-op" data-post="'+id+'">';
        html += '<img src="'+img_url+'" alt="'+title+'">';
        html +='<h5>'+title+'</h5>';
        html +='</div>';
        $("#service-op .modal-body").prepend(html);
        $("#service-op").modal("toggle");
        return false;
    });
    //load meta packages
    $(".service-op .item .sv-overlay").click(function(){        
        var _token = $("#service-op form input[name='_token']").val();
        var total = 0;
        var count = 0;        
        var package_ids = new Array();
        var meta_ids = new Array();
        $(this).parents(".item").toggleClass("active");
        if($(this).parents(".item").hasClass("active")){
            $(this).parents(".item").find(".wrap").prepend('<i class="fas fa-check-circle"></i>');
        }else{
            $(this).parents(".item").find(".fa-check-circle").remove()
        }
        $(".service-op .list-service .item").each(function(){
            var package_id = $(this).attr("data-value");
            var meta_id = $(this).attr("data-meta");
            if($(this).hasClass("active")){
                package_ids[count] = {
                    'meta_title' : $(this).find(".middle .title").text(),
                    'meta_unit' : $(this).find(".middle .time").attr("data-unit"),
                    'meta_id' : meta_id,
                    'package_id' : package_id,
                };
                count = count+1;
            }else{
                $(this).find(".fa-check-circle").remove();
                $("#service-op .metas-packages #pak-"+package_id).remove();
            }
        });
        $(".service-op .metas-packages .box").each(function(){
            meta_ids.push($(this).find('.list .mt-active').attr('data-id'));
        });
        $.ajax({
            type:'POST', 
            url:location.protocol + "//" + location.host+'/profile/metas-package',
            cache: false,
            data:{
                '_token': _token,
                'package_ids': JSON.stringify(package_ids),
                'meta_ids': JSON.stringify(meta_ids),
            },
        }).done(function(data) {
            if(data.message!="error"){
                $("#service-op .metas-packages").html(data.html);
                var html ='<a href="#" data-value="'+data.meta_ids+'" class="btn-normal btn-payment">'+data.total+' - Thanh toán ngay</a>';
                $(".service-op .group-action .btn-payment").remove();
                $(".service-op .group-action").prepend(html);
            }else{
                $("#service-op .metas-packages").empty();
                $("#service-op .btn-payment").remove();
            }                  
        });        
    });
    //load price
    $(".service-op").on('click','.metas-packages .list li',function(){
        var packages = new Array();        
        var parent = $(this).parent(".list").attr("id");
        var package_id = $(this).parent(".list").attr('data-value');
        var meta_id = $(this).attr('data-id');
        $('#'+parent+' li').removeClass('mt-active');
        $(this).addClass('mt-active');
        $(".service-op .metas-packages .box").each(function(){           
            packages.push($(this).find('.list .mt-active').attr('data-id'));
        });          
        var _token = $("#service-op form input[name='_token']").val();
        $.ajax({
            type:'POST',
            url:location.protocol + "//" + location.host+'/profile/canculate-metas',
            cache: false,
            data:{
                '_token': _token,
                'meta_id': meta_id,
                'packages': JSON.stringify(packages),
            },
        }).done(function(data) {
            if(data.message!="error"){
                $("#service-op .list-service #package-"+package_id).attr('data-meta', meta_id);
                $("#service-op #package-"+package_id+" .middle .time").text(data.time+' '+data.unit);
                $("#service-op #package-"+package_id+" .middle .price .sale").attr('data-value',data.price);
                $("#service-op #package-"+package_id+" .middle .price .sale").html(data.price_text);
                var html ='<a href="#" data-value="'+packages.toString()+'" class="btn-normal btn-payment">'+data.total+' - Thanh toán ngay</a>';
                $(".service-op .group-action .btn-payment").remove();
                $(".service-op .group-action").prepend(html);
            }
        });
    });
    //payment service news
    $("#service-op").on('click','.group-action .btn-payment',function(){        
        var _token = $("form input[name='_token']").val();
        var meta_ids = $(this).attr("data-value");
        $(this).append('<img class="loading" src="'+location.protocol + "//" + location.host+'/public/images/loading_red.gif" alt="loadding..."/>');
        $.ajax({
            type:'POST',            
            url:location.protocol + "//" + location.host+'/admin/blog/payment-service',
            cache: false,
            data:{
                '_token': _token,
                'meta_ids': meta_ids,
                'article_id': $(".article-op").attr("data-post")
            },
        }).done(function(data) {
            if(data!="error"){window.location.href = $('.dev-form').attr('action');}
        });
        return false;
    });

    //input price
    $('input.price').on('input', function(){
    	if(event.which >= 37 && event.which <= 40) return;

	  	// format number
	  	$(this).val(function(index, value) {
		    return value
		    .replace(/\D/g, "")
		    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
		    ;
	  	});
	  	$(this).attr('data-value', $(this).val().replace(/,/g, ''))
	});
	/**
	 * products
	 */
	if($('.menu-sub-cat').length){
		$(".menu-sub-cat").on('click','.dropdown-toggle',function(){        
		$(".menu-sub-cat .dropdown-menu").slideToggle(0);
		});
		$(".menu-sub-cat .dropdown-menu").on('click','li a',function(){
			$(".menu-sub-cat .dropdown-toggle").attr("data-value", $(this).attr("data-value"));
			$(".menu-sub-cat .dropdown-toggle").text($(this).text());
			if($(this).parents('.dropdown').find('input.value').length){ 
				$(this).parents('.dropdown').find('input.value').val($(this).attr("data-value"));
			}
			$(".menu-sub-cat .dropdown-menu").slideToggle(0);
			return false;
		});
		$(".menu-sub-cat .dropdown-menu").on('click','.open-sub',function(){
			$(this).find("i.fa").toggleClass('fa-lemon-o');
			$(this).parent(".has-child").find(".sub-menu").slideToggle(0);
			return false;
		});
	}

	/*
	* count character
	*/
	$('.form-group input, .form-group textarea').on('input', function(){
    	$(this).parents('.form-group').find('.count-characters').text('( ' + $(this).val().length + ' ký tự )');
    });
    /*
    * Color picker
    */
	if($('#color').length){
    	$('#color').colorpicker();
	}

	/*
	* sortable
	*/
	if($('.sortable').length){
		$(".sortable" ).sortable({
		    update: function(e, ui) {
		        var count = 0;
		        var route_count = 0;
		        var routes = new Array();
		        $(".sortable .ui-state-default").each(function(){
		        	count = count + 1;
		        	$(this).attr("data-position",count);
		        	routes[route_count] = {
						'id' : $(this).attr("data-value"),
						'position' : $(this).attr("data-position")
					}
					route_count = route_count + 1;
		        });

		        //if this is wrap-gallery
		        if($(this).hasClass('wrap-gallery')){
		        	var array_value = [];
		        	$(this).parent().find('.gallery-item').each(function(){
						array_value.push($(this).attr('data-id'));
					});
					$(this).parent().find(".thumb-media").val(JSON.stringify(array_value));
		        }

				var routes = JSON.stringify(routes);
				var _token = $("form input[name='_token']").val();
				var link = $(this).attr('data-action');
				if(link != undefined && link != ''){
					$.ajax({
		               	type:'POST',
					    url: link,
					    cache: false,
			            data:{
			                '_token': _token,
			                'routes': routes,
			            },
		           }).done(function(data) {
		           		if(data == "success"){
		           			new PNotify({
							    title: 'Thành công',
							    text: 'Thay đổi vị trí chương thành công',
							    type: 'success',
							    hide: true,
							    delay: 2000,
							});
		           		}else{
		           			new PNotify({
							    title: 'Error',
							    text: 'Hệ thống đang gặp sự cố. Vui lòng thử lại sau.',  
							    hide: true,
							    delay: 2000,
							});
		           		}	
		           });
		       }
		    }
		});
	}

	/*
	* Seletc2
	*/
    if($('.select2').length){
		/*$('.select2').select2({
		    placeholder: "Select a state"
		});*/
		$('.select2').select2();
	}

	/*
	* upload image comic
	*
	*/
		

});
//format currency
function formatCurrency(number, places, symbol, thousand, decimal) {
    number = number || 0;
    places = !isNaN(places = Math.abs(places)) ? places : 0;
    symbol = symbol !== undefined ? symbol : "đ";
    thousand = thousand || ".";
    decimal = decimal || ".";
    var negative = number < 0 ? "-" : "",
        i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "")+" "+symbol;
}
//format
function numberFormat(number, places, thousand, decimal) {
    number = number || 0;
    places = !isNaN(places = Math.abs(places)) ? places : 0;    
    thousand = thousand || ",";
    decimal = decimal || ".";
    var negative = number < 0 ? "-" : "",
        i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");
}
//convert to slug
function convertToSlug(str){
	str = str.replace(/^\s+|\s+$/g, ''); // trim
	str = str.toLowerCase();

	// remove accents, swap ñ for n, etc
	var from = "àáäảâẫạặăẵèéëêệẹìịíïîòóöôộùúüûưủñçđ·/_,:;";
	var to   = "aaaaaaaaaaeeeeeeiiiiiooooouuuuuuncd------";

	for (var i=0, l=from.length ; i<l ; i++)
	{
		str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
	}

	str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
		.replace(/\s+/g, '-') // collapse whitespace and replace by -
		.replace(/-+/g, '-'); // collapse dashes

	return str;
}
//validate email
function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
}