@extends('templates.master')
@section('title','Lịch sử coin')
@section('content')
	<div class="payment content-coin">
		<div class="wrapper-coin">
			<div class="container">
				@include('members.coin_header')
				@include('members.menu_coin')
				<div class="content-tabs">
					lịch sử coin
				</div>
			</div>
		</div>
	</div>
@endsection