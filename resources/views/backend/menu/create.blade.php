@extends('backend.layout.index')
@section('title','Thêm menu')
@section('content')
<div id="add-menu-page" class="container page menu-page">
	<div class="head">
		<a href="{{route('menu')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> Menu</a>
		<h1 class="title">Thêm Menu</h1>		
	</div>
	<div class="main">
		<form id="create-menu" action="{{route('creatMenu')}}" class="frm-menu" method="POST" name="create_menu" role="form"/>
		{!!csrf_field()!!}
		<div class="row">				
			<div class="col-md-8 left-box">			
				<section class="box-wrap box-title">
					<h2 class="title">Tên</h2>
					<input type="text" name="title" placeholder="vd: Menu chính, footer..." class="mn-title frm-input">
				</section>
				<section class="box-wrap mn-link">
					<h2 class="title">Liên kết</h2>
					<div class="list">
						<p class="empty">Menu này chưa có liên kết nào.</p>
						<ul class="sortable" data-recores="0">							
						</ul>
					</div>
					<button class="btn-add"><i class="fa fa-plus-circle" aria-hidden="true"></i> Thêm liên kết</button>
				</section>
			</div>		
			<div class="col-md-4 sidebar right-box">			
				<section class="box-wrap">
					<h2 class="title">Alias</h2>
					<div class="desc">Alias là định danh làm đường dẫn hiển thị trên thanh địa chỉ trình duyệt và có thể được dùng để truy cập các thuộc tính của Menu trong Liquid.<a target="_blank" href="#">Tìm hiểu thêm</a></div>
					<input type="text" name="alias" class="frm-input mn-alias">
				</section>
			</div>				
		</div>
		<div class="group-action">
			<a href="{{route('menu')}}" class="btn btn-cancel">Hủy</a>
			<button type="submit" name="submit" class="btn">Lưu</button>			
		</div>
	</form>			
</div>
</div>
<script type="text/javascript">
	$(function() {		
		$(".sortable" ).sortable({			
		    update: function(e, ui) {
		        var count = 0;
		        $(".sortable .ui-state-default").each(function(){
		        	count = count + 1;
		        	$(this).attr("data-position",count);
		        });
		    }
		});		
		//create slug
		$(".frm-menu .mn-title").keyup(function(){
			var title = $(this).val();
			if(title.length>0)
				$("#create-menu .mn-alias").val(convertToSlug(title));
			else
				$("#create-menu .mn-title").val("");
		});
		//add recore		
		$(".menu-page").on('click','.btn-add',function(){
			$("#add-menu-page .left-box .list .empty").remove();
			var recores = $(".mn-link .list .sortable").attr("data-recores");
			number = parseInt(recores) + 1;
			$(this).parents(".box-wrap").find(".sortable").attr("data-recores",number);
			var html = '<li id="'+number+'" class="ui-state-default item-'+number+' new" data-position="'+number+'">';
					html = html + '<div class="link-title">';
					html = html + '<input type="text" name="links[]" placeholder="Nhập tên liên kết" class="frm-input" /><i class="fa fa-trash" aria-hidden="true"></i>';
					html = html + '</div>';
					html = html + '<div class="row link-content">';
					html = html + '{!!menuType()!!}';
					html = html + '<div class="dropdown show type-value col-md-7"></div>';
					html = html + '</div>';
				html = html + '</li';
			$(".list .sortable .item-"+number).find(".link-content .type .dropdown-toggle").attr("id","type-"+number);
			$(".list .sortable .item-"+number).find(".link-content .type .dropdown-menu").attr("aria-labelledby","type-"+number);
			$(".list .sortable").append(html);
			return false;
		});
		//filter
		var types = ["#page","#product","#products","#collection","#blog"];
		$(".menu-page").on("click", ".link-content .type .list-item a", function() {
			var a_href = $(this).attr("href");
			var a_txt = $(this).attr("data-value");
			var count = $(this).parents(".ui-state-default").attr("id");
			$(this).parent(".list-item").find("a").removeClass("active");
			$(this).addClass("active");			
			$(this).parents(".type").find(".dropdown-toggle").text($(this).text());
			$(this).parents(".dropdown-menu").removeClass("show");
			
			$('.sortable .item-'+count+' .link-content .type-value').html('<a class="dropdown-toggle" href="'+a_href+'" role="button" id="result-type-'+count+'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Chọn '+a_txt+'</a>');

			if(types.indexOf(a_href) != -1){
				$(this).parents(".link-content").find(".type-value .dropdown-toggle").addClass("active");
			}else{
				$(this).parents(".link-content").find(".type-value .dropdown-toggle").removeClass("active");
			}
			if(a_href == "#link"){
				$html = '<input name="custome_link" type="text" class="frm-input custom-link"/>';
				$html +='<a class="dropdown-toggle hide" href="'+a_href+'" role="button" id="result-type-'+count+'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Chọn '+a_txt+'</a>';
				$('.sortable .item-'+count+' .link-content .type-value').html($html);
			}
			return false;

		});
		$(".menu-page").on('keyup','.link-content .type-value .custom-link',function(){			
			$(this).parent(".type-value").find(".dropdown-toggle").attr("data-value",$(this).val());
		});
		$(".menu-page").on('click','.link-content .type-value .dropdown-toggle',function(){
			var _token = $(".frm-menu input[name='_token']").val();
			var type = $(this).attr("href");			
			var number = $(this).parents(".ui-state-default").attr("id");
			$(".sortable .item-"+number).find('.type-value .dropdown-menu').remove();
			var html = '<div class="dropdown-menu" aria-labelledby="result-type-'+number+'">';
				html +='<div class="search-input">';
				html +='<i class="fa fa-search" aria-hidden="true"></i>';
				html +='<input type="text" class="frm-input" placeholder="Tìm kiếm danh mục"/>';
				html +='</div>';
				html +='</div>';
			$(".sortable .item-"+number).find('.type-value').append(html);
			$.ajax({
	            type:'POST',            
			    url:'{{ route("loadType") }}',
			    cache: false,
	            data:{
	                '_token': _token,
					'type': type
	            },
	            success:function(data){     	
	                $(".sortable .item-"+number).find('.type-value .dropdown-menu').append(data);
	            }
	        });	        
		});

		$(".menu-page").on('click','.link-content .type-value .list-item a',function(){
			$(this).parents(".type-value").find(".dropdown-toggle").text($(this).text());
			$(this).parents(".type-value").find(".dropdown-toggle").attr('data-value',$(this).attr("data-value"));
			$(this).parents(".dropdown-menu").removeClass("show");			
			return false;
		});
		//pagination
		$(document).on('click','.pagination a', function(e){
           	e.preventDefault();
           	var _token = $(".frm-menu input[name='_token']").val();
			var type = $(this).attr("href");
           	var page = $(this).attr('href').split('page=')[1];
           	var number = $(this).parents(".ui-state-default").attr("id");
           
           $.ajax({
               	type:'POST',            
			    url:'{{ route("loadType") }}',
			    cache: false,
	            data:{
	                '_token': _token,
					'type': type,
					'page': page
	            },
           }).done(function(data) {
           		$(".sortable .item-"+number).find('.type-value .search-input').remove();				
				var	html ='<div class="search-input">';
					html +='<i class="fa fa-search" aria-hidden="true"></i>';
					html +='<input type="text" class="frm-input" placeholder="Tìm kiếm danh mục"/>';
					html +='</div>';
					html +='</div>';				
                $(".sortable .item-"+number).find('.type-value .dropdown-menu').html(html+data);
           });
           return false;
       }); 
       //key search
       $(".menu-page").on('keyup','.link-content .type-value .search-input input',function(){
			var _token = $(".frm-menu input[name='_token']").val();
			var type = $(this).parents(".type-value").find(".dropdown-toggle").attr("href");           	           	
           	var number = $(this).parents(".ui-state-default").attr("id");
           $.ajax({
               	type:'POST',            
			    url:'{{ route("searchMenu") }}',
			    cache: false,
	            data:{
	                '_token': _token,
					'type': type,
					'title': $(this).val()
	            },
           }).done(function(data) {
           		$(".sortable .item-"+number).find('.type-value .list-item').remove();
           		$(".sortable .item-"+number).find('.type-value .pagination').remove();
                $(".sortable .item-"+number).find('.type-value .dropdown-menu').append(data);
           });
		});       
		$(".sortable").on('click','i.fa-trash',function(){						
			$(this).parents(".ui-state-default").remove();
		 	var count = 0;
	        $(".sortable .ui-state-default").each(function(){
	        	count = count + 1;
	        	$(this).attr("data-position",count);
	        });
		});
       //create menu
       $(".menu-page").on('click','.frm-menu .group-action button',function(){
			var _token = $(".frm-menu input[name='_token']").val();
			var title = $(".frm-menu .mn-title").val();
           	var new_metas = new Array();
			var new_count = 0;
			var errors = new Array();
			var error_count = 0;
			$(".menu-page .list .sortable .ui-state-default").each(function(){
				var error = $(this).find(".type-value .dropdown-toggle").attr("data-value");
				if( error === undefined){
					errors[error_count] = $(this).attr("id");
					error_count = error_count + 1;
				}
				new_metas[new_count] = {
					'title' : $(this).find(".link-title .frm-input").val(),
					'title_value' : $(this).find(".type-value .dropdown-toggle").text(),
					'type' : $(this).find(".type-value .dropdown-toggle").attr("href"),
					'value' : $(this).find(".type-value .dropdown-toggle").attr("data-value"),
					'position' : $(this).attr("data-position")
				}
				new_count = new_count + 1;
			});			
			var new_metas= JSON.stringify(new_metas);				
			if(errors.length > 0){
				new PNotify({
				    title: 'Có lỗi với menu',
				    text: 'Một hoặc nhiều liên kết chưa chọn giá trị!.',
				    hide: true,
				    delay: 2000,
				});
			}else{
	           $.ajax({
	               	type:'POST',            
				    url:'{{ route("creatMenu") }}',
				    cache: false,
		            data:{
		                '_token': _token,
						'title':title,
						'metas': new_metas
		            },
	           }).done(function(data) {
	           		new PNotify({
					    title: 'Thành công',
					    text: 'Thêm menu thành công.',
					    type: 'success',
					    hide: true,
					    delay: 2000,
					});
	           });
	       }
           return false;
		});
	});	
</script>
@stop