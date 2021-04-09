<div id="library-op" class="modal single" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Chose file</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation"><a href="#addFile" aria-controls="addFile" role="tab" data-toggle="tab">Upload file</a></li>
					<li role="presentation" class="active"><a href="#media" aria-controls="media" role="tab" data-toggle="tab">Media comics</a></li>
				</ul>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane" id="addFile">
						<div id="dropzone">	
							<form action="{{ route('createMediaComic') }}" class="dropzone" id="frmTarget">
								{!! csrf_field() !!}
								<input type="hidden" name="category" id="category" value="">
							</form>
							<div class="group-action">
								<button type="submit" name="submit" class="btn">Save</button>
								<button type="button" class="btn btn-cancel" data-dismiss="modal">Cancle</button>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane active" id="media">
						<form action="{{ route('deleteMediaSingle')}}" name="media" method="post">
							{!! csrf_field() !!}
							<input type="hidden" name="loadMoreMedia" class="more-media" value="{{ route('loadMorePage') }}">
							<div class="row">
								<div class="col-md-10">
									<div class="row top">
										<div id="media-find" class="col-md-10 search-input">
											<i class="fa fa-search" aria-hidden="true"></i>
											<input type="text" class="frm-input" placeholder="Tìm kiếm file">
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
								<a href="#" class="btn btn-primary">Chose</a>
								<button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
	$(document ).ready(function(){
		//search key
		$("#library-op #media-find input").keyup(function(){
			var value = $(this).val();			
			var _token = $("#library-op #media input[name='_token']").val();
			var catId = $("#library-op #media #media-cat .dropdown-toggle").attr("data-value");
			$.ajax({
				type:'POST',            
				url:'{{route("filterMedia")}}',
				cache: false,
				data:{
					'_token': _token,
					's': value,
					'catId': catId,
				},
				success:function(data){
					$(".loadding").hide();
					if(data.message!="error"){
						$('#library-op .modal-body #files .list-media').html(data.html);
						$("#library-op #files .limit").val(data.limit);
						$("#library-op #files .current").val(data.current);
						$("#library-op #files .total").val(data.total);
					}
				}
			});
		});
       //filter media by cat
       $("#library-op #media-cat").on('click','.list-item a',function(){
       		var value = $(this).attr("data-value");
   			var _token = $("#library-op #media input[name='_token']").val();
   			$(this).parents("#media-cat").find(".dropdown-toggle").attr("data-value",value);
   			$(this).parents("#media-cat").find(".dropdown-toggle").text($(this).text());
   			$("#library-op #files .limit").val('');			
			$("#library-op #files .current").val('');
			$("#library-op #media-cat .list-item a").removeClass("active");
			$(this).addClass("active");
        	$.ajax({
				type:'POST',            
				url:'{{route("filterMedia")}}',
				cache: false,
				data:{
					'_token': _token,
					'catId': value,
					's': $("#library-op #media-find input").val(),
				},
				success:function(data){
					$(".loadding").hide();
					if(data.message!="error"){
						$('#library-op .modal-body #files .list-media').html(data.html);
						$("#library-op #files .limit").val(data.limit);
						$("#library-op #files .current").val(data.current);
						$("#library-op #files .total").val(data.total);
					}
				}
			});			
       });
       //search media cat
       $("#library-op #media-cat .search-input input").keyup(function(){       		
   			var _token = $("#library-op #media input[name='_token']").val();			
        	$.ajax({
				type:'POST',            
				url:'{{route("searchCatMedia")}}',
				cache: false,
				data:{
					'_token': _token,
					's': $(this).val(),
				},
				success:function(data){
					$(".loadding").hide();
					if(data.message!="error"){
						$('#library-op #media-cat .list-item').html(data.html);						
					}
				}
			});			
       });
       //add media
		var cat_ids = new Array();		
		Dropzone.options.frmTarget = {
			autoProcessQueue: false,
			// uploadMultiple: true,
			parallelUploads: 100,
			maxFiles:100,
			url: '{{ route("createMedia") }}',
			init: function () {
				var myDropzone = this;
		        // Update selector to match your button
		        $("#dropzone button").click(function (e) {
		        	e.preventDefault();
		        	$("#category").val("");
		        	$("#sb-mediaCat .checkbox").each(function(){
		        		if($(this).find("input").is(":checked")){
		        			cat_ids.push($(this).find("input").val());
		        		}
		        	});
		        	$("#category").val(cat_ids.toString());		            
		        	myDropzone.processQueue();
		        });
		        this.on('sending', function(file, xhr, formData) {
		            // Append all form inputs to the formData Dropzone will POST
		            var data = $('#frmTarget').serializeArray();
		            $.each(data, function(key, el) {
		            	formData.append(el.name, el.value);
		            });
		            formData.append('category', $('#category').val());
		        });
		        this.on("complete", function(file) {
		        	cat_ids = [];
		        	$("#sb-mediaCat .checkbox input").prop('checked', false);
		        	myDropzone.removeFile(file);
		        	var _token = $("#library-op #media input[name='_token']").val();		
		        	$.ajax({
						type:'POST',            
						url:'{{route("loadMedia")}}',
						cache: false,
						data:{
							'_token': _token
						},
						success:function(data){
							$(".loadding").hide();
							$('#library-op .modal-body #files .list-media').html(data.html);
							$("#library-op #media-cat .dropdown-toggle").attr("data-value","");
							$("#library-op #media-find input").val("");
							$("#library-op #media-cat .list-item a").removeClass("active");
						}
					})
		        });
		    }
		}		
	});
</script>