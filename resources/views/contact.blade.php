@extends('templates.master')
@section('title',$page->title)
@section('content')
	<div id="contact-page" class="static-pages">	
		<div class="container">
			<div class="inner">
				<div class="sec-title"><h3>{{ $page->title }}</h3></div>
				<div class="sec-content">
					<div class="row">
						<div class="col-md-8">
							<form id="form-contact" action="{{ route('updateContact') }}" method="POST" name="contact" class="dev-form" role="form">
								{{ csrf_field()  }}
								<div class="row">
									<div class="col-md-6">
										<div id="frm-fullname" class="form-group">
											<label for="fullname" class="control-label">{{ _('Tên/ Name') }}<small>(*)</small></label>
											<input type="text" name="fullname" id="fullname" class="form-control" placeholder="Tên của bạn" >
										</div>
										<div id="frm-email" class="form-group">
											<label for="email" class="control-label">{{ _('Email') }}<small>(*)</small></label>
											<input type="email" name="email" id="email" class="form-control" placeholder="Địa chỉ Email của bạn">
										</div>
										<div id="frm-phone" class="form-group">
											<label for="phone" class="control-label">{{ _('Phone') }}<small>(*)</small></label>
											<input type="text" name="phone" id="phone" class="form-control" >
										</div>
										<div class="form-group" id="frm-subject">
											<label>{{ _('Chủ đề/ Subject') }}</label>
											<select name="subject" class="fỏm-control">
												<option value="" selected>{{ _('Chọn một/ Choose one') }}</option>
												<option value="suggest">{{ _('Góp ý/ Suggest') }}</option>
												<option value="report">{{ _('Báo lỗi/ Report an error') }}</option>
												<option value="advertisement">{{ _('Quảng cáo/ Advertisement') }}</option>
												<option value="copyright">{{ _('DCMA/ Copyright') }}</option>
												<option value="other">{{ _('Khác/ Other') }}</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div id="frm-message" class="form-group">
											<label for="message" class="control-label">{{ _('Nội dung/ Message') }}<small>(*)</small></label>
											<textarea name="message" id="message" class="form-control" rows="12" placeholder="Nội dung liên hệ"></textarea>
										</div>
										<div id="frm-submit" class="form-group text-right"><button type="submit" class="btn btn-primary">{{ _('Gửi/ Send') }}</button></div>
									</div>
								</div>																		
							</form>
						</div>
						<div class="col-md-4">
							<h4><i class="fas fa-globe-asia"></i>  Thông tin liên hệ/ Contact info</h4>
							{!! $page->content !!}
						</div>
					</div>						
				</div>
			</div>
		</div>
		<div id="map"></div>
	</div>
@endsection
{{-- @section('script')
	<script type="text/javascript">	
		function loadMap() {
			var myCenter = {lat: {{ latMap() }}, lng: {{ logMap() }}};
			var map = new google.maps.Map(document.getElementById('map'), {
				center: myCenter,
				zoom: 14,
				mapTypeId:google.maps.MapTypeId.ROADMAP
			});
			var marker = new google.maps.Marker({
				position:myCenter,
				title: '{{ nameCompany() }}',
				draggable: true,
				animation:google.maps.Animation.BOUNCE,
			});
			marker.setMap(map);
			var infowindow = new google.maps.InfoWindow({     
				content: '{!! address() !!}'
			});
			infowindow.open(map,marker);
		}   
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCP7vrRL2fG7Rke3mbxEpW9BCH5suPBbl0&libraries=places&callback=loadMap" async defer></script>
@endsection --}}