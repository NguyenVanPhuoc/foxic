@extends('templates.auth')
@section('title','Forgot password ')
@section('content')
	<div id="login-page" class="page">
		<div class="container">
			<div id="login-from" class="box">
				
				<div class="wrap">	
					<h2 class="well-txt">{{ _('Forgot your password?') }}</h2>
				{{-- @if(count($errors)>0)
					<div class="alert alert-danger">
						<ul>
							@foreach($errors->all() as $error)
							<li>{{$error}}</li>	
							@endforeach
						</ul>
					</div>
				@endif
				@if(session('notify')) <div class="alert alert-danger">{{ session('notify') }}</div> @endif --}}
					<form action="{{ route('postForgotPassword') }}" method="post" name="login">
						{{ csrf_field() }}
						<input type="text" placeholder="Vui lòng nhập email" name="email" class="txt" />
						<input type="submit" name="submit" value="Submit" class="btn">
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection