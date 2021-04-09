@extends('backend.layout.index')
@section('title','Onepay config')
@section('content')
@php $coins = getCoins('onepay'); @endphp
<div id="gamebank-api" class="page p-api">
	<div class="head container">
		<h1 class="title">Onepay API</h1>		
	</div>	
	<div class="main">
		<ul class="nav-filter">
			<li><a href="{{route('APIAdmin',['type'=>'gamebank'])}}">Gamebank</a></li>
			<li class="active"><a href="{{route('APIAdmin',['type'=>'atm'])}}">ATM</a></li>
		</ul>
		<form action="{{route('editAPIAdmin',['type'=>'atm'])}}" method="POST" name="blog" class="dev-form">
			{!!csrf_field()!!}
			<div class="row api-info">
				<div class="col-md-4 left-box clearfix">
					<div class="wrap">
						<h3 class="title-h3">Thông số kết nối</h3>
						<div id="frm-secret" class="form-group">
							<label for="">Secure Secret<small class="required">*</small></label>
							<input type="text" name="secret" class="form-control" value="{{$options->onepay_secureSecret}}">
						</div>
						<div id="frm-code" class="form-group">
							<label for="">Access Code<small class="required">*</small></label>
							<input type="text" name="code" class="form-control" value="{{$options->onepay_accessCode}}">
						</div>
					</div>
				</div>
				<div class="col-md-8 right-box clearfix">
					<div class="wrap">
						<h3 class="title-h3">Quy đổi coin</h3>					
						<div id="frm-meta">
							<ul class="sortable number-format" data-recores="{{count($coins)}}">
								@if($coins)
									@php $count = 0; @endphp
									@foreach($coins as $item) @php $count++; @endphp
									<li id="{{$item->id}}" class="ui-state-default item-{{$count}} old" data-position={{$count}}>
										<div class="row">
											<div class="col-md-8 col-sm-8 col-xs-8 frm-money">
												<input type="text" name="icon_{{$count}}" placeholder="Số tiền cần quy đổi" class="frm-input txt-number" value="{{numberFormat($item->money)}}">
											</div>
											<div class="col-md-4 col-sm-4 col-xs-4 clearfix frm-coin">
												<input type="text" name="coin_{{$count}}" placeholder="Số coin" class="frm-input txt-number" value="{{numberFormat($item->coin)}}">
												<i class="fa fa-trash" aria-hidden="true"></i>
											</div>
										</div>
									</li>
									@endforeach								
								@endif
							</ul>
							<button class="btn-add"><i class="fa fa-plus-circle" aria-hidden="true"></i> Thêm coin</button>
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
		$(".sortable" ).sortable({			
		    update: function(e, ui) {
		        var count = 0;
		        $(".sortable .ui-state-default").each(function(){
		        	count = count + 1;
		        	$(this).attr("data-position",count);
		        });
		    }
		});
		//add recore
		$("#frm-meta").on('click','.btn-add',function(){
			var recores = $("#frm-meta .sortable").attr("data-recores");
			number = parseInt(recores) + 1;
			$("#frm-meta .sortable").attr("data-recores",number);
			var html = '<li class="ui-state-default item-'+number+' new" data-position="'+number+'">';
					html = html + '<div class="row">';
					html = html + '<div class="col-md-8 col-sm-8 col-xs-8 frm-money"><input type="text" name="money-'+number+'" placeholder="Số tiền cần quy đổi" class="frm-input txt-number"/></div>';
					html = html + '<div class="col-md-4 col-sm-4 col-xs-4 clearfix frm-coin "><input type="text" name="coin-'+number+'" placeholder="Số coin" class="frm-input txt-number" /><i class="fa fa-trash" aria-hidden="true"></i></div>';
					html = html + '</div>';
				html = html + '</li>';
			$("#frm-meta .sortable").append(html);
			return false;
		});
		//remove record
		var del_items = new Array();
		$(".sortable").on('click','i.fa-trash',function(){
			if($(this).parents(".ui-state-default").hasClass("old")){
				var item_id = $(this).parents(".ui-state-default").attr("id");
				del_items.push(item_id);
			}			
			$(this).parents(".ui-state-default").remove();
		 	var count = 0;
	        $(".sortable .ui-state-default").each(function(){
	        	count = count + 1;
	        	$(this).attr("data-position",count);
	        });
		 	$(".sortable").attr("data-recores",count);
		});
		$("#gamebank-api").on('click','form .group-action button',function(){
			var _token = $("form input[name='_token']").val();
			var secret = $("#frm-secret input").val();			
			var code = $("#frm-code input").val();
			var new_metas = new Array();
           	var old_metas = new Array();
           	var errors = new Array();			
			var old_count = 0;
			var new_count = 0;
			var error_count = 0;
			$(".sortable .ui-state-default").each(function(){
				var money = $(this).find(".frm-money input").val();
				var coin = $(this).find(".frm-coin input").val();
				var position = $(this).attr("data-position");
				if(money !="" && coin !=""){
					if($(this).hasClass('old')){
						old_metas[old_count] = {
							'meta_id' : $(this).attr("id"),
							'meta_money' : money,
							'meta_coin' : coin,
							'meta_position' : position
						}
						old_count = old_count + 1;
					}else{
						new_metas[new_count] = {
							'meta_money' : money,
							'meta_coin' : coin,
							'meta_type' : 'onepay',
							'meta_position' : position
						}
						new_count = new_count + 1;
					}
				}else{
					errors.push('Một/nhiều hàng chưa nhập giá trị money/coin.');
				}
			});				
			if(secret=="") errors.push('Vui lòng nhập Secure Secret.');
			if(code=="") errors.push('Vui lòng nhập Access Code.');	
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
						'secret': secret,
						'code': code,
						'old_metas': JSON.stringify(old_metas),
						'new_metas': JSON.stringify(new_metas),
						'del_items': JSON.stringify(del_items),
					},
				}).done(function(data) {
					$(".dev-form .loading").remove();
					if(data=="success"){
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