@extends('backend.layout.index')
@section('title','lịch sử giao dịch')
@section('content')
@php	
	$type = empty($_GET["type"])? 'news' : $_GET["type"];	
	$start = empty($_GET["start"])? '' : $_GET["start"];
	$end = empty($_GET["end"])? '' : $_GET["end"];
@endphp
<div id="histories" class="page p-histories">
	<div class="head container">
		<h1 class="title">Lịch sử giao dịch</h1>		
	</div>	
	<div class="main">
		<div class="row search-filter">
			<div class="col-md-6 search-form">
				<form name="s" action="{{route('transactionsAdmin')}}" method="GET">
					<div class="row">
						<input type="hidden" name="type" value="{{$type}}">
						<div id="frm-start" class="col-md-6 col-sm-6 col-xs-6">
							<div class="date-noHour input-group">
								<input type="hidden" name="start" placeholder="Ngày bắt đầu" class="form-control flatpickr-input" value="{{$start}}">							
								<div class="input-group-addon"><span class="glyphicon glyphicon-th"></span></div>
							</div>
						</div>
						<div id="frm-end" class="col-md-6 col-sm-6 col-xs-6">
							<div class="date-noHour input-group">
								<input type="hidden" name="end" placeholder="Ngày kết thúc" class="form-control flatpickr-input" value="{{$end}}">							
								<div class="input-group-addon"><span class="glyphicon glyphicon-th"></span></div>
							</div>
						</div>
					</div>
					<button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>
				</form>
			</div>
			<div class="col-md-6 filter">
				<ul class="nav-filter">
					<li<?php if($type=="news") echo ' class="active"';?>><a href="{{route('transactionsAdmin')}}?type=news&start={{$start}}&end={{$end}}">Nâng cấp tin</a></li>
					<li<?php if($type=="card") echo ' class="active"';?>><a href="{{route('transactionsAdmin')}}?type=card&start={{$start}}&end={{$end}}">Giao dịch thẻ</a></li>
					<li<?php if($type=="atm") echo ' class="active"';?>><a href="{{route('transactionsAdmin')}}?type=atm&start={{$start}}&end={{$end}}">Chuyển khoản</a></li>
				</ul>
			</div>
		</div>
		@if($transactions)			
			<form method="POST" name="transactions" action="{{route('transactionsAdmin')}}" class="dev-form" data-delete="{{route('deleteTransactionsAdmin',['type'=>$type])}}">
				{!!csrf_field()!!}
				@if($type=="news")
					@include('backend.histories.list_news')
				@elseif($type=="card")
					@include('backend.histories.list_card')
				@else
					@include('backend.histories.list_atm')
				@endif
			</form>
			{!! $transactions->links() !!}
		@endif
	</div>
	
</div>
@if(session('success'))
<script type="text/javascript">
	$(function(){
		new PNotify({
		    title: 'Thành công',
		    text: 'Xóa Thành công.',
		    type: 'success',
		    hide: true,
		    delay: 2000,
		});
	})
</script>
@endif
<script type="text/javascript">
	$(function() {		
      	$(".p-histories .search-form").on('click','button',function(){						
			var start = $("#frm-start input").val();
			var end = $("#frm-end input").val();
			if(start=="" || end==""){
				PNotify.removeAll();
				new PNotify({
					title: 'Lỗi dữ liệu',
					text: 'Vui lòng chọn khoản thời gian',						    
					hide: true,
					delay: 6000,
				});
			}else{
				return true;
			}
			return false;
		});		
	});	
</script>
@stop