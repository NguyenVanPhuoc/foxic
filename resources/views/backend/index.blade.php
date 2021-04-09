@extends('backend.layout.index')
@section('title','Trang chủ')
@section('content')
<h2 class="title">Trang chủ</h2>
@if(count($errors)>0)
<div class="alert alert-danger">
	<ul>
		@foreach($errors->all() as $error)
		<li>{{$error}}</li>	
		@endforeach
	</ul>
</div>
@endif
@if(session('thanhcong'))
<div class="alert alert-success">{{session('thanhcong')}}</div>
@endif
<form id="home-page" action="#" method="post" name="home" class="dev-form">
	<input type="hidden" name="_token" value="{{csrf_token()}}"/>
	<div class="form-group" id="name">
		<label for="name">Tiêu đề<small>(*)</small></label>
		<input type="text" name="title" class="form-control" value=""/>		
	</div>
	<div id="all-services" class="section">
		<div class="top">
			<label for="top_service">Giao hàng tận nơi cực nhanh</label>
			<textarea name="top_service" class="form-control" id="top_service"></textarea>
		</div>
		<div class="lits row">
			<div class="col-md-4">
				<label for="top_service">Tiết kiệm thời gian</label>
				<textarea name="top_service_01" class="form-control" id="top_service_01"></textarea>
			</div>
			<div class="col-md-4">
				<label for="top_service">Tiết kiệm chi phí</label>
				<textarea name="top_service_02" class="form-control" id="top_service_02"></textarea>
			</div>
			<div class="col-md-4">
				<label for="top_service">Tránh mọi phiền phức</label>
				<textarea name="top_service_03" class="form-control" id="top_service_03"></textarea>
			</div>
		</div>
	</div>
	<div id="shipper" class="section">
		<label for="shipper">Shipper</label>
		<textarea name="shipper" class="form-control" id="shipper_value"></textarea>	
	</div>
	<div id="shoper" class="section">
		<label for="shipper">shoper</label>
		<textarea name="shoper" class="form-control" id="shoper_value"></textarea>	
	</div>
	<div class="form-group btn-group">
		<button type="submit" class="btn btn-primary">Lưu</button>		
		<button type="reset" class="btn btn-secondery">Làm lại</button>		
	</div>
</form>
<script>
    ckeditor('top_service');
    ckeditor('top_service_01');
    ckeditor('top_service_02');
    ckeditor('top_service_03');
    ckeditor('shipper_value');
    ckeditor('shoper_value');
</script>
@stop