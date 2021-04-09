$(document ).ready(function(){	
	$('#frm-type-tile select').on('change', function(){
		var link = '';
		var form = $(this).closest('form');
		if($(this).closest('#frm-type-tile').attr('data-action') != undefined)
			link = $(this).closest('#frm-type-tile').attr('data-action');
		if(link != ''){
			var value = $(this).val();
			$('.loading').show();
			$.ajax({
				type:'GET',
				url:link,
				cache: false,
				data:{
					'value': value
				},
				success:function(data){
					$('.loading').hide();
					form.find('input[name=title]').val(data);
				}
			})
		}
	});
});