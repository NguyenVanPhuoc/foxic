$(document).ready(function(){
    
    $("#main-menu > li > a").on('click',function(e){
        e.preventDefault();
        if($(this).parent("li").hasClass('active')){
            $(this).parent("li").removeClass('active');
            $(this).parent('li').siblings('li').removeClass('active');
            $(this).siblings('.sub-menu').find('.sub-menu').hide();
        }else{
            $(this).parent("li").addClass('active');
        }
        $(this).siblings(".sub-menu").slideToggle();
        $(this).parent('li').siblings('li').find(".sub-menu").hide();
        $(this).parent('li').siblings('li').removeClass('active');
    });
    $("header .top").on('click', '.btn-icon-menu', function() {
        $(this).parents('.top').find('.menu-mobi').toggleClass('open');
        $('#overlay').show();
    })
    $("header .top").on('click', '.close-mobi', function() {
        $(this).parents('.top').find('.menu-mobi').removeClass('open');
        $('#overlay').hide();
    })
    //$('.menu-mobi ul.menu-left li ul').scrollbar();
});