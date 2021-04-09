@php
	$mediaCats = getMediaCats();
	$list_oldMedia = '';
	if(isset($chap)){
		$list_oldMedia = getListOldMediaOfChap($chap->id);
	}
	elseif(isset($comic)){
		$list_oldMedia = getListOldMediaOfComic($comic->id);
	}
@endphp 
<div id="library-op" class="modal single 123" role="dialog" data-type="">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">{{ _('Chọn ảnh') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation"><a href="#addFile" aria-controls="addFile" role="tab" data-toggle="tab">{{ _('Thêm ảnh') }}</a></li>
					<li role="presentation" class="active"><a href="#media" aria-controls="media" role="tab" data-toggle="tab">{{ _('Thư viện') }}</a></li>
					@if(isset($chap))
						<li class=""><a href="#oldChosen" aria-controls="media" role="tab" data-toggle="tab">{{ _('Ảnh của chương này') }}</a></li>
					@elseif(isset($comic))
						<li class=""><a href="#oldChosen" aria-controls="media" role="tab" data-toggle="tab">{{ _('Ảnh của truyện này') }}</a></li>
					@endif
				</ul>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane" id="addFile">
						<div id="dropzone">	
							<div class="row">
								<div class="col-md-3 sidebar">
									<section id="sb-image-of" class="box-wrap">
										<h2 class="title">{{ _('Ảnh của') }}</h2>
										<div class="gr-radio flex-list center-item">
					                        <input class="gender" type="hidden" tabindex="-1" value="1">
					                        <div class="radio radio-primary radio-inline">
					                            <input type="radio" name="radio" id="image_of1" value="system" checked>
					                            <label for="image_of1">{{ _('Hệ thống') }}</label>
					                        </div>
					                        <div class="radio radio-primary radio-inline">
					                            <input type="radio" name="radio" id="image_of2" value="comic">
					                            <label for="image_of2">{{ _('Truyện') }}</label>
					                        </div>
					                    </div>
									</section>
									<section id="sb-mediaCat" class="box-wrap">
										<h2 class="title">{{ _('Danh mục') }}</h2>	
										@if(isset($mediaCats))
										<div class="desc list">
											@foreach($mediaCats as $item)
											<div class="checkbox checkbox-success item">
												<input id="item-{{ $item->id }}" type="checkbox" name="mediaCats[]" value="{{ $item->id }}">
												<label for="item-{{ $item->id }}">{{ $item->title }}</label>
											</div>
											@endforeach
										</div>
										@endif
									</section>
								</div>
								<div class="col-md-9 content">
									<form action="{{ route('storeMedia') }}" class="dropzone" id="frmTarget">
										{{ csrf_field() }}
										<input type="hidden" name="category" id="category" value="">
										<input type="hidden" name="image_of" value="">
										<input type="hidden" name="array_chose" value="">
										<div class="dz-message needsclick">{{ _('Thả file ảnh ở đây hoặc bấm vào để tải lên.') }}</div>
									</form>
									<div class="group-action">
										<button type="submit" name="submit" class="btn">{{ _('Lưu') }}</button>
										<button type="button" class="btn btn-cancel" data-dismiss="modal">{{ _('Huỷ') }}</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane active" id="media">
						<form action="{{ route('deleteMediaSingle') }}" name="media" method="post">
							{{ csrf_field() }}
							<input type="hidden" name="loadMoreMedia" class="more-media" value="{{ route('loadMorePage') }}">
							<div class="row">
								<div class="col-md-10">
									<div class="row top">
										<div id="media-cat" class="col-md-2 dropdown show form-group">
											@if($mediaCats)
												<select class="select2 form-control">
													<option value="">{{ _('Tất cả danh mục') }}</option>
													@foreach($mediaCats as $item)
														<option value="{{ $item->id }}">{{ $item->title }}</option>
													@endforeach
												</select>
											@endif
										</div>
										<div id="image-of" class="col-md-2">
											<select>
												<option value="">{{ _('Tất cả loại') }}</option>
												<option value="system">{{ _('Hệ thống') }}</option>
												<option value="comic">{{ _('Truyện') }}</option>
											</select>
										</div>
										<div id="media-find" class="col-md-8 search-input">
											<i class="fa fa-search" aria-hidden="true"></i>
											<input type="text" class="frm-input" placeholder="Nhập tên ảnh">
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
								<a href="#" class="btn btn-primary">{{ _('Đồng ý') }}</a>
								<button type="button" class="btn btn-cancel" data-dismiss="modal">{{ _('Đóng') }}</button>
							</div>
						</form>
					</div>
					<div role="tabpanel" class="tab-pane" id="oldChosen">
						<form action="{{ route('deleteMediaSingle') }}" name="media" method="post">
							{{ csrf_field() }}
							<div class="row">
								<div class="col-md-10">
									<div class="row top">
										<div class="col-md-6"><input type="text" class="frm-input" placeholder="Nhập tên ảnh"></div>
									</div>
									<div id="oldFiles" class="scrollbar-inner">
										@if($list_oldMedia != '')
											<ul class="list-media">
												@include('backend.media.list_template')
											</ul>
										@else
											{{ _('Không có ảnh') }}
										@endif
									</div>
								</div>
								<div id="file-detail" class="col-md-2"></div>
							</div>
							<div class="modal-footer group-action">
								<span class="library-notify"></span>
								<a href="#" class="btn btn-primary">{{ ('Đồng ý') }}</a>
								<button type="button" class="btn btn-cancel" data-dismiss="modal">{{ _('Đóng') }}</button>
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
		/*$("#library-op #media-find input").keyup(function(){
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
		});*/
		$("#library-op #media-find input").on('input', function(){
			setTimeout(function(){ 
	  			filterAjax();	
	  		}, 500);
  		});

       //filter media by cat
       $("#library-op #media-cat").on('change','select',function(){
       		filterAjax();
       });

       $("#library-op #image-of").on('change','select',function(){
       		filterAjax();
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
		        });
		    },
			success: function(file, response){
                console.log(response);
                if(response.msg == 'success'){
	                $(".loading").hide();
					$('#library-op .modal-body #files .list-media').html(response.html);
					$("#library-op #media-cat select").val("");
					$("#library-op #image-of select").val("");
					$("#library-op #media-find input").val("");
					$("#library-op a[href=#media]").trigger('click');
				}
            }
		}		
	});

	/*
    * function filterAjax
    */
    function filterAjax(){
    	var _token = $('input[name=_token]').val();
    	var s = $('#library-op #media-find input').val();
    	var catId = $("#library-op #media-cat select").val();
    	var image_of = $('#library-op #image-of select').val();
    	$('#overlay').show();
    	$(".loading").show();

        $.ajax({
			type:'POST',            
			url:'{{route("filterMedia")}}',
			cache: false,
			data:{
				'_token': _token,
				's': s,
				'catId': catId,
				'image_of': image_of,
			},
			success:function(data){
				$('#overlay').hide();
				$(".loading").hide();
				if(data.message!="error"){
					$('#library-op .modal-body #files .list-media').html(data.html);
					$("#library-op #files .limit").val(data.limit);
					$("#library-op #files .current").val(data.current);
					$("#library-op #files .total").val(data.total);
				}
			}
		});	
    }
</script>