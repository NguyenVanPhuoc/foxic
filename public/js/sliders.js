jQuery(document).ready(function($){
    // home slider 
    if($('#home').length){
        var owlBanner = $('#slider .list-slide');
        owlBanner.owlCarousel({
            items:1,
            loop:true,
            margin:0,
            autoplay:true,
            nav:false, 
            dots:true, 
            autoplayTimeout:5000,
            autoplayHoverPause:true
        });
        owlBanner.on('changed.owl.carousel', function(event) {
            var bg = $(this).find('.owl-item.active > .image').attr('data-bg');
            $(this).closest('#slider').css({
                'background-image': 'url('+bg+')',
            });
        });  

        var owlRecent = $('#recent .list-comics');
        owlRecent.owlCarousel({
            items:4,
            loop:true,
            margin:20,
            autoplay:true,
            nav:true, 
            dots:false, 
            navText:['<i class="far fa-chevron-left"></i>','<i class="far fa-chevron-right"></i>'],
            autoplayTimeout:5000,
            autoplayHoverPause:true,
        });
        var owlCatComic = $('.cat-comic .list-comics');
        owlCatComic.owlCarousel({
            items:1,
            loop:true,
            margin:0,
            autoplay:true,
            nav:true, 
            dots:false, 
            navText:['<i class="far fa-chevron-left"></i>','<i class="far fa-chevron-right"></i>'],
            autoplayTimeout:5000,
            autoplayHoverPause:true,
        });
    }
    $('.list-novel').owlCarousel({
        items:3,
        loop:true,
        margin:0,
        center: true,
        autoplay:true,
        nav:false,
        dots:true, 
        navText:['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
        autoplayTimeout:3000,
        autoplayHoverPause:true,
        responsive : {
            0:{
                items:1,
            },
            320:{
                items:2,
                center:false,
            },
            768:{
                items:3,
            }
        }
    });
   
    if($(window).width() > 1024 ){
         // category slider new vip
        $('.slide-banner').owlCarousel({
            items:1,
            loop:true,
            margin:0,
            autoplay:true,
            nav:true,
            dots:true, 
            navText:['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
            autoplayTimeout:3000,
            autoplayHoverPause:true,
            
        });
        
         // category slider new vip
        $('#news-vip .list').owlCarousel({
            items:5,
            loop:true,
            margin:15,
            autoplay:true,
            nav:false,
            dots:false, 
            navText:['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
            autoplayTimeout:2000,
            autoplayHoverPause:true,
            responsive : {
                0:{
                    items:1
                },
                320:{
                    items:1
                },
                480:{
                    items:1,
                },
                568:{
                    items:2,
                },
                991:{
                    items:3,
                },
                1024:{
                    items:5,
                }
            } 
        });

        $('#sec-news-vip .list').owlCarousel({
            items:1,
            loop:false,
            margin:15,
            autoplay:true,
            nav:false,
            dots:true, 
            navText:['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
            autoplayTimeout:2000,
            autoplayHoverPause:true,
        });
         //others articles - detail
        $('#others .list').owlCarousel({
            items:3,
            loop:false,
            margin:15,
            autoplay:true,
            nav:true,
            dots:false, 
            navText:['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
            autoplayTimeout:2000,
            autoplayHoverPause:true,
        });
    }
    else{
        $('#sec-news-vip .list').owlCarousel({
            items:3,
            loop:false,
            margin:15,
            autoplay:false,
            nav:true,
            dots:true, 
            navText:['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
            autoplayTimeout:2000,
            autoplayHoverPause:true,
            responsive : {
                0:{
                    items:1
                },
                320:{
                    items:1
                },
                480:{
                    items:1,
                },
                568:{
                    items:2,
                },
                991:{
                    items:3,
                }
            } 
        });
        $('#news-adv .list').owlCarousel({
            items:2,
            loop:false,
            margin:15,
            autoplay:true,
            nav:true,
            dots:false, 
            navText:['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
            autoplayTimeout:2000,
            autoplayHoverPause:true,
            responsive : {
                0:{
                    items:1
                },
                320:{
                    items:1
                },
                480:{
                    items:1,
                },
                568:{
                    items:2,
                },
            } 
        });
        $('#others .list').owlCarousel({
            items:1,
            loop:false,
            margin:15,
            autoplay:false,
            nav:true,
            dots:false, 
            navText:['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
            autoplayTimeout:2000,
            autoplayHoverPause:true,
        });
        $('#news-vip .list').owlCarousel({
            items:3,
            loop:true,
            margin:15,
            autoplay:true,
            nav:true,
            dots:true, 
            navText:['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
            autoplayTimeout:2000,
            autoplayHoverPause:true,
            responsive : {
                0:{
                    items:1
                },
                320:{
                    items:1
                },
                480:{
                    items:1,
                },
                568:{
                    items:2,
                },
                991:{
                    items:3,
                },
                1024:{
                    items:3,
                }
            } 
        });

    }

    $('.list-reviews').owlCarousel({
        items:3,
        loop:true,
        margin:15,
        autoplay:true,
        nav:true,
        dots:true, 
        navText:['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
        autoplayTimeout:2000,
        autoplayHoverPause:true,
        responsive : {
            0:{
                items:1
            },
            320:{
                items:1
            },
            480:{
                items:1,
            },
            568:{
                items:2,
            },
            991:{
                items:3,
            },
            1024:{
                items:3,
            }
        } 
    });


    //related-slide
    $('.related-slide').owlCarousel({
        items:4,
        loop:true,
        margin:15,
        autoplay:true,
        nav:true,
        dots:false, 
        navText:['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
        autoplayTimeout:2000,
        autoplayHoverPause:true,
        responsive : {
            0:{
                items:1
            },
            320:{
                items:1
            },
            480:{
                items:1,
            },
            568:{
                items:2,
            },
            991:{
                items:3,
            },
            1024:{
                items:4,
            }
        } 
    });
})