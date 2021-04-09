@if (session('error'))
    <div class="alert alert-danger" role="alert">{!! session('error') !!}</div>
@endif
@if (session('success'))
    <div class="alert alert-success" role="alert">{!! session('success') !!}</div>
@endif
@if (session('modal_show'))
	<div id="modal_master" class="modal fade modal-cs show in">
		<div class="modal-dialog">
			<div class="modal-content">
			    <div class="modal-body text-center">
				    <h4 class="text-popup">{{ session('modal_show') }}</h4>
			    </div>
			    <div class="modal-footer">
		        <button type="button" class="btn btn-danger btn-close" data-dismiss="modal">Close</button>
		      </div>
			</div>
		</div>
	</div> 
@endif
@if ($errors->any())
    <div class="alert alert-danger"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif
@if(session('errorMonth')) 
@php
	$months = session('errorMonth');
@endphp
    <div class="alert alert-danger" role="alert">
    	@foreach($months as $item)
    		<p>{{ $item }}</p>
    	@endforeach
    </div>
@endif