@extends('backend.layout.index')
@section('title','APIs config')
@section('content')
<div id="onepay-api" class="page p-api">
	<div class="head container">
		<h1 class="title">APIs</h1>		
	</div>	
	<div class="main">
		<form action="{{route('saveAPIsAdmin')}}" method="POST" class="dev-form activity-form">
			{!!csrf_field()!!}
			<div class="api-info">
				<div class="left-box clearfix">
					<div class="wrap">
						<h3 class="title-h3">Connection parameters</h3>
						<div class="row">
							<div class="col-md-6">
								<h4>Paypal</h4>
								<div class="form-group">
									<label for="">Paypal Email<small class="required">*</small></label>
									<input type="text" name="paypal_email" class="form-control" value="{{$options->paypal_email}}">
								</div>
							</div>
							<div class="col-md-6">
								<h4>Stripe</h4>
								<div class="form-group">
									<label>Live Publishable Key<small class="required">*</small></label>
									<input type="text" name="stripe_publishable_key" class="form-control" value="{{$options->stripe_publishable_key}}">
								</div>
								<div class="form-group">
									<label>Live Secret Key<small class="required">*</small></label>
									<input type="text" name="stripe_secret_key" class="form-control" value="{{$options->stripe_secret_key}}">
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
			<div class="group-action"><button type="submit" class="btn">Save</button></div>
		</form>
	</div>
</div>
@stop