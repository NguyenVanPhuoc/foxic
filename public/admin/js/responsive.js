$(document).ready(function(){
	var doc = $("#wrapper").height();
	$("#sidebar").css("height",doc);
	$("header .navbar-right").on('click','.mobi-nav-icon', function(){
        $("#sidebar").addClass("active");
        $('#overlay').fadeIn('3000');
        $(this).parents('body').addClass('active');
    });
    $("#overlay").on("click",function(){
        $('#overlay').fadeOut('3000');
        $("#sidebar").removeClass("active");
        $(this).parents('body').removeClass('active');
    });
	// Hide Header on on scroll down menu
	var didScroll;
    var lastScrollTop = 0;
    var delta = 5;
    var navbarHeight = $('header').outerHeight();

    $(window).scroll(function(event){
        didScroll = true;
    });

    setInterval(function() {
        if (didScroll) {
            hasScrolled();
            didScroll = false;
        }
    }, 250);

    function hasScrolled() {
        var st = $(this).scrollTop();
        
        // Make sure they scroll more than delta
        if(Math.abs(lastScrollTop - st) <= delta)
            return;
        
        // If they scrolled down and are past the navbar, add class .nav-up.
        // This is necessary so you never see what is "behind" the navbar.
        if (st > lastScrollTop && st > navbarHeight){
            // Scroll Down
            $('header').removeClass('nav-down').addClass('nav-up');
        } else {
            // Scroll Up
            if(st + $(window).height() < $(document).height()) {
                $('header').removeClass('nav-up').addClass('nav-down');
            }
        }
        lastScrollTop = st;
    }
    // Show info plus when not desktop
	$('.action .view').click(function(){
		var parent_item = $(this).parents('tr').attr('id');
		if($('tr.'+parent_item).hasClass('active')){
			$('tr.'+parent_item).removeClass('active');
		}
		else{
			$('.info-detail').removeClass('active');
			$('tr.'+parent_item).addClass('active');
		}
		return false;
	});
});