
<div id="library-op" class="modal single" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">{{ _('Mời chọn file') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<ul class="nav nav-tabs">
					<li><a href="#addFile" data-toggle="tab">{{ _('Thêm tập tin') }}</a></li>
					<li class="active"><a href="#media" a data-toggle="tab" >{{ _('Thư viện') }}</a></li>
				</ul>
				<div class="tab-content">
					<div id="addFile" class="tab-pane fade">
						<div id="dropzone">
							<div class="row">
								<div class="col-md-10">
									<form action="{{ route('storeMediaProfile') }}" class="dropzone dev-form" id="frmTarget">
										{{ csrf_field() }}
									</form>
								</div>
								<div class="col-md-2">
									<div class="modal-footer flex item-center content-between group-action">
										<button type="submit" name="submit" class="btn btn-submit">{{ _('Lưu') }}</button>
										<button type="button" class="btn btn-cancel" data-dismiss="modal">{{ _('Đóng') }}</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="media" class="tab-pane fade in active">
						<form action="{{-- {{ route('deleteLibraryProfile') }} --}}" name="media" method="post">
							{{ csrf_field() }}
							<input type="hidden" name="loadMoreMediaProfile" class="more-media" value="{{ route('loadMoreMediaProfile') }}">
							<div class="row">
								<div class="col-md-10">
									<div class="top">
										<div id="media-find" class="search-input">
											<i class="fa fa-search" aria-hidden="true"></i>
											<input type="text" class="frm-input form-control" placeholder="Tìm kiếm file">
										</div>
									</div>
									<div id="files" class="scrollbar-inner">
										<ul class="list-media"></ul>
											<input type="hidden" name="limit" class="limit" value="">
											<input type="hidden" name="current" class="current" value="">
											<input type="hidden" name="current" class="total" value="">
									</div>
								</div>
								<div id="file-detail" class="col-md-2"></div>
							</div>
							<div class="modal-footer group-action">
								<span class="library-notify"></span>
								<a href="#" class="btn btn-primary btn-submit">{{ _('Đồng ý') }}</a>
								<button type="button" class="btn btn-cancel" data-dismiss="modal">{{ _('Đóng') }}</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	<script type="text/javascript">
		jQuery(document ).ready(function($){
			//search key
			$("#library-op #media-find input").keyup(function(){
				var value = $(this).val();
				var _token = $("#library-op #media input[name='_token']").val();
				$(".loading").show();
				$('#overlay').show();
				$.ajax({
					type:'POST',
					url:'{{ route("filterMediaProfile") }}',
					cache: false,
					data:{
						'_token': _token,
						's': value,
					},
					success:function(data){
						$(".loading").hide();
						$('#overlay').hide();
						if(data.message != "error"){
							$('#library-op .modal-body #files .list-media').html(data.html);
							$("#library-op #files .limit").val(data.limit);
							$("#library-op #files .current").val(data.current);
							$("#library-op #files .total").val(data.total);
						}
					}
				});
			});
			// add media
			Dropzone.options.frmTarget = {
				autoProcessQueue: false,
				// uploadMultiple: true,
				parallelUploads: 100,
				maxFiles:10,
				maxFilesize: 1, // MB
				url: '{{ route("storeMediaProfile") }}',
				init: function () {
					var myDropzone = this;
					// Update selector to match your button
					$("#dropzone button").click(function (e) {
						e.preventDefault();
						myDropzone.processQueue();
					});
					this.on('sending', function(file, xhr, formData) {
						// Append all form inputs to the formData Dropzone will POST
						var data = $('#frmTarget').serializeArray();
						$.each(data, function(key, el) {
							formData.append(el.name, el.value);
						});
					});
					this.on("complete", function(file) {
						cat_ids = [];
						myDropzone.removeFile(file);
						var _token = $("#library-op #media input[name='_token']").val();
						$(".loading").show();
						$.ajax({
							type:'POST',
							url:'{{ route("loadMoreMediaProfile") }}',
							cache: false,
							data:{
								'_token': _token,
							},
							success:function(data){
								$(".loading").hide();
								$('#library-op .modal-body #files .list-media').html(data.html);
								$("#library-op #media-find input").val("");
							}
						})
					});
				}
			}
		});
	</script>


