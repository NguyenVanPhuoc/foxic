$(document).ready(function(){	

	// Stickers
	$('.show_sticker').on('click', function(e) {
		e.preventDefault();
		$(this).closest('form').find('.list-packages').slideToggle();
	});

	$('.list-packages .package-btn').on('click', function(e) {
		e.preventDefault();
		$('.list-stickers').not($(this).siblings('.list-stickers')).hide();
		$(this).siblings('.list-stickers').slideToggle();
	});

	$('.dev-form .choose-sticker').on('click', function(e) {
		e.preventDefault();
		var id = $(this).attr('href');
		var img = $(this).html();
		$('.dev-form input[name="sticker_cmt"]').val(id);
		$(this).closest('.list-packages').siblings('.current_sticker').html(img);
		$(this).closest('.list-stickers').hide();
	});
})