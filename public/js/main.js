$(document ).ready(function(){
   
    $(".notification").on('click', '.number-notify', function() {
        $(".notification ul.notifies").toggle();
    });
    $(".time-go").timeago();
    // Hide Header on on scroll down menu
    var didScroll;
    var lastScrollTop = 0;
    var delta = 5;
    var navbarHeight = $('header').outerHeight();
    
    $(window).scroll(function(event) {
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
        if (Math.abs(lastScrollTop - st) <= delta)
            return;
        // If they scrolled down and are past the navbar, add class .nav-up.
        // This is necessary so you never see what is "behind" the navbar.
        if (st > lastScrollTop && st > navbarHeight) {
            // Scroll Down
            $('header').removeClass('nav-down').addClass('nav-up');
        } else {
            // Scroll Up
            if (st + $(window).height() < $(document).height()) {
                $('header').removeClass('nav-up').addClass('nav-down');
            }
        }
        //
        if (st > 50) $('header').addClass('fixed');
        else $('header').removeClass('fixed');

        lastScrollTop = st;
    }
    //back to top
    // $('body #wrapper').append('<div id="backtotop"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i></div>');
    $(window).scroll(function() {
        if ($(window).scrollTop() > 200) {
            $('#backtotop').fadeIn();
        } else {
            $('#backtotop').fadeOut();
        }
    });
    $('#backtotop').click(function() {
        $('html, body').animate({
            scrollTop: 0
        }, 500);
    });
    //scroll to comment
    $(".social-share .ic-comment a").click(function() {
        $('html, body').animate({
            scrollTop: $(".fb-comments").offset().top - 100
        }, 500);
        return false;
    });
    //check change password
    $(".check-password input").change(function() {
        if ($(this).is(':checked')) {
            $(".change-password input").prop('disabled', false);
            $(this).val("on");
        } else {
            $(".change-password input").prop('disabled', true);
            $(this).val("");
        }
        $(".change-password").slideToggle(100);
    });
    //search
    $("#search-frm .dropdown-menu").on('click', '.list-item a', function() {
            $("#search-frm .type").val($(this).attr("data-value"));
        })
        //dropdown
    $(".dropdown-menu").on('click', '.list-item a', function() {
        $(this).parents('.dropdown-menu').find('li a').removeClass('active');
        $(this).parents('.dropdown').find('.dropdown-toggle').attr("data-value", $(this).attr("data-value"));
        $(this).parents('.dropdown').find('.dropdown-toggle span').text($(this).text());
        $(this).addClass('active');
    });
    //contact
    if($("#contact-page").length){
        $("#form-contact").on('click', '#frm-submit button', function(e) {
            e.preventDefault();
            var errors = new Array();
            var error_count = 0;
            var _token = $(".dev-form input[name='_token']").val();
            var link = $("#form-contact").attr('action');
            var name = $("#frm-fullname input").val();
            var email = $("#frm-email input").val();
            var phone = $("#frm-phone input").val();    
            var subject = $("#frm-subject select").val();
            var message = $("#frm-message textarea").val();
            if (name == "") errors.push("Please enter fullname!");
            if (email == "" || validateEmail(email) == false) errors.push("Email invalidate!");
            if (phone == "") errors.push("Please enter the phone number!");
            if (message == "") errors.push("Please enter content!");
            if (subject == "") errors.push("Please enter subject!");
            var i;
            var html = "<ul>";
            for (i = 0; i < errors.length; i++) {
                if (errors[i] != "") {
                    html += '<li>' + errors[i] + '</li>';
                    error_count += 1;
                }
            }
            if (error_count > 0) {
                html += "</ul>";
                new PNotify({
                    title: 'Errors (' + error_count + ')',
                    text: html,
                    hide: true,
                    delay: 6000,
                });
            } else {
                $('#overlay').show();
                $('loading').show();
                $.ajax({
                    type: 'POST',
                    url: link,
                    cache: false,
                    data: {
                        '_token': _token,
                        'name': name,
                        'email': email,
                        'phone': phone,
                        'subject': subject,
                        'message': message
                    },
                }).done(function(data) {
                    $('#overlay').show();
                    $('loading').show();
                    if (data != "error") {
                        new PNotify({
                            title: 'Send success',
                            text: data,
                            type: 'success',
                            hide: true,
                            delay: 2000,
                        });
                        location.reload();
                    } else {
                        new PNotify({
                            title: 'The system is overloaded. Please try again later!.',
                            text: error,
                            hide: true,
                            delay: 2000,
                        });
                    }
                });
            }
            return false;
        });
    }
    
    //socical share buttons
    var popupSize = {
        width: 780,
        height: 550
    };
    $(".social-icons").on('click', 'li a', function(e) {
        var
            verticalPos = Math.floor(($(window).width() - popupSize.width) / 2),
            horisontalPos = Math.floor(($(window).height() - popupSize.height) / 2);
    
        var popup = window.open($(this).prop('href'), 'social',
            'width=' + popupSize.width + ',height=' + popupSize.height +
            ',left=' + verticalPos + ',top=' + horisontalPos +
            ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');
    
        if (popup) {
            popup.focus();
            e.preventDefault();
        }
    });
    //captcha
    $('#frm-captcha i.fa-sync-alt').on('click', function(e) {
        e.preventDefault();
        var anchor = $(this);
        var captcha = anchor.prev('img');
        $.ajax({
            type: "GET",
            url: '/ajax_regen_captcha',
        }).done(function(msg) {
            captcha.attr('src', msg);
        });
        
    });
    //show phone
    $("#author-info .desc .phone a").click(function() {
            $(this).hide();
            $("#author-info .desc .phone h3").show();
            return false;
        })
    /**
     * like
     */
    $(".blog").on('click', '.like-post', function() {
        console.log(111);
        var value = parseInt($(this).attr("data-value"));
        var postId = $(this).find(".fa-heart").attr("data-value");
        if ($(this).attr("data-log") == "") {
            $('#notify-op').modal('toggle');
        } else {
            var _token = $(this).attr("data-token");
            $(this).append('<img class="loading" src="' + location.protocol + "//" + location.host + '/public/images/loading_red.gif" alt="loading...">');
            $.ajax({
                type: 'POST',
                url: location.protocol + "//" + location.host + '/profile/like-news',
                cache: false,
                data: {
                    '_token': _token,
                    'postId': postId
                },
            }).done(function(data) {
                $("#post-" + postId + " .loading").remove();
                if (data != "error") {
                    if (data == "like") {
                        $("#post-" + postId + " .fa-heart").removeClass("far");
                        $("#post-" + postId + " .fa-heart").addClass("fas");
                    } else {
                        $("#post-" + postId + " .fa-heart").removeClass("fas");
                        $("#post-" + postId + " .fa-heart").addClass("far");
                    }
                    $(this).attr("data-value", data);
                }
            });
        }
        return false;
    });
    $("#blog-detail .like-post").click(function() {
        var postId = $(this).find(".fa-heart").attr("data-value");
        if ($(this).attr("data-log") == "") {
            $('#notify-op').modal('toggle');
        } else {
            var _token = $(this).attr("data-token");
            $(this).append('<img class="loading" src="' + location.protocol + "//" + location.host + '/public/images/loading_red.gif" alt="loading...">');
            $.ajax({
                type: 'POST',
                url: location.protocol + "//" + location.host + '/profile/like-news',
                cache: false,
                data: {
                    '_token': _token,
                    'postId': postId,
                },
            }).done(function(data) {
                $("#blog-detail .loading").remove();
                if (data != "error") {
                    if (data == "like") {
                        $("#blog-detail .fa-heart").removeClass("far");
                        $("#blog-detail .fa-heart").addClass("fas");
                    } else {
                        $("#blog-detail .fa-heart").removeClass("fas");
                        $("#blog-detail .fa-heart").addClass("far");
                    }
                    $(this).attr("data-value", data);
                }
            });
        }
        return false;
    });
    $('#comic-page .group-episode .like-comic').click(function(e) {
            e.preventDefault();
            var comicId = $(this).attr("data-value");
            if ($(this).attr("data-log") == "") {
                $('#notify-op').modal('toggle');
            } else {
                var _token = $(this).attr("data-token");
                var link = $(this).attr('href');
                $(this).parents('.group-episode').append('<img class="loading" src="' + location.protocol + "//" + location.host + '/public/images/loading_red.gif" alt="loading...">');
                $.ajax({
                    type: 'POST',
                    url: link,
                    cache: false,
                    data: {
                        '_token': _token,
                        'comicId': comicId,
                    },
                }).done(function(data) {
                    $("#comic-page .group-episode .loading").remove();
                    if (data != "error") {
                        if (data == "like") $("#comic-page .group-episode .like-comic").addClass("check");
                        else $("#comic-page .group-episode .like-comic").removeClass("check");
                        $(this).attr("data-value", data);
                    }
                });
            }
            return false;
        })
        //login
    $(".login-op").on('click', '.modal-footer .btn-primary', function() {
        var errors = new Array();
        var error_count = 0;
        var _token = $(".login-op input[name='_token']").val();
        var link = $(".login-op .modal-body form").attr("action");
        var pass = $(".login-op #frm-pass input").val();
        var email = $(".login-op #frm-email input").val();
        if (pass == "") errors.push("Vui l??ng nh???p m???t kh???u");
        if (email == "" || validateEmail(email) == false) errors.push("Email invalidate!");
        var i;
        var html = "<ul>";
        for (i = 0; i < errors.length; i++) {
            if (errors[i] != "") {
                html += '<li>' + errors[i] + '</li>';
                error_count += 1;
            }
        }
        html += "</ul>";
        if (error_count > 0) {
            new PNotify({
                title: 'L???i d??? li???u (' + error_count + ')',
                text: html,
                hide: true,
                delay: 6000,
            });
        } else {
            $(".login-op .modal-body").append('<div class="loading"><img src="' + location.protocol + "//" + location.host + '/public/images/loading_red.gif" alt="loading..."></div>')
            $.ajax({
                type: 'POST',
                url: link,
                cache: false,
                data: {
                    '_token': _token,
                    'pass': pass,
                    'email': email
                },
            }).done(function(data) {
                $(".login-op .modal-body .loading").remove();
                if (data.message == "success") {
                    window.location.reload();
                } else {
                    new PNotify({
                        title: 'Login error',
                        text: 'Email / Password is not correct!',
                        type: 'error',
                        hide: true,
                        delay: 2000,
                    });
                }
            });
        }
        return false;
    });
    
    //message popup
    $('.message-popup .close').click(function() {
        $(this).closest('.message-popup').fadeOut();
        $('#overlay').fadeOut();
    });
    
    if ($('#ongoing-page').length) {
        $('#ongoing-page #list-day li.active').each(function() {
            $(this).removeClass('today');
        });
    }
    
    /*
     * overlay click
     */
    $('#overlay').click(function() {
        $('#overlay').hide();
        $('.message-popup').hide();
        $('.menu-mobi').removeClass('open');
    });
    
    /*
     * show search form
     */
    if ($('header .search').length) {
        $('header .search').on('click', '.btn-show', function(e) {
            e.preventDefault();
            $(this).closest('.search').find('.search-box').addClass('active');
        });
        $(window).click(function(e) {
            if ($(e.target).closest('.search').html() == undefined) {
                $('header .search-box').removeClass('active');
            }
        });
    }
    $('.scrollbar-inner').scrollbar();
    if ($('header .menu-left').length) {
        if ($('.menu-left .has-child').length) {
            var height_menu_main = $('.menu-left .has-child > .sub-menu').outerHeight();
            var width_menu_main = $('.menu-left .has-child > .sub-menu').outerHeight();
            $('.menu-left .has-child .has-child .sub-menu').css({
                'max-height': height_menu_main,
                'min-width': width_menu_main,
            });
            $('li.has-child').on('mouseover', function() {
                var $menuItem = $(this);
                $wrap = $('> .wrap', $menuItem);
                // grab the menu item's position relative to its positioned parent
                var menuItemPos = $menuItem.position();
                // place the submenu in the correct position relevant to the menu item
                $wrap.css({
                    top: menuItemPos.top,
                    left: menuItemPos.left + Math.round($menuItem.outerWidth())
                });
            });
        }
    }
    /*
     * show menu action
     */
    if ($('header .account').length) {
        $('.account').on('click', '.profile .btn-myShow', function(e) {
            e.preventDefault();
            $(this).closest('.profile-action').find('.action').toggleClass('active');
        });
    }
    /*
     *
     */
    if ($('header .family-safe').length) {
        $('.family-safe').on('click', 'a', function(e) {
            e.preventDefault();
            var _token = $(this).attr("data-token");
            var link = $(this).attr('href');
            if ($(this).attr('data-check') != '') {
                if ($(this).closest('li').hasClass('active')) {
                    $.ajax({
                        type: 'POST',
                        url: link,
                        cache: false,
                        data: {
                            '_token': _token,
                            'status': 'off',
                        },
                    }).done(function(data) {
                        if (data.message == "success") {
                            $('.header .family-safe').removeClass('active');
                            $('.header .family-safe a').attr('data-check', data.status);
                            location.reload();
                        }
                    });
                } else {
                    $.ajax({
                        type: 'POST',
                        url: link,
                        cache: false,
                        data: {
                            '_token': _token,
                            'status': 'on',
                        },
                    }).done(function(data) {
                        if (data.message == "success") {
                            $('.header .family-safe').addClass('active');
                            $('.header .family-safe a').attr('data-check', data.status);
                            location.reload();
                        }
                    });
                }
            }
            return false;
        });
    }
    if ($('#ageVerification-page').length) {
        $('#ageVerification-page').on('click', '.group-btn .btn', function(e) {
            e.preventDefault();
            var status = $(this).attr('data-value');
            var _token = $(this).closest('.group-btn').find('input[name="_token"]').val();
            var link = $(this).closest('.group-btn').find('input[name="check_age"]').val();
            var comic = $(this).closest('.group-btn').find('input[name="comic"]').val();
            if ($(this).attr('data-value') == 'no' || $(this).attr('data-value') == 'yes') {
                if ($(this).attr('data-value') != 'no') {
                    $.ajax({
                        type: 'POST',
                        url: link,
                        cache: false,
                        data: {
                            '_token': _token,
                            'status': status,
                            'comic': comic,
                        },
                    }).done(function(data) {
                        if (data.message == "success") {
                            window.location.href = data.url;
                        }
                    });
    
                } else {
                    $.ajax({
                        type: 'POST',
                        url: link,
                        cache: false,
                        data: {
                            '_token': _token,
                            'status': status,
                            'comic': comic,
                        },
                    }).done(function(data) {
                        if (data.message == "success") {
                            window.location.href = data.url;
                        }
                    });
                }
            }
            return false;
        });
    }
    /*
    * Load ajax select category comic hot and type comic value
    */
   if($('#home').length){
        if($('#hot').length){
            $('#hot .sec-title').on('change','select#hot-select',function(){
                var _token = $(this).attr('data-token');
                var link = $(this).attr('data-link');
                var type_hot = $(this).val();
                $('#overlay').show();
                $('.loading').show();
                $.ajax({
                    type: 'POST',
                    url: link,
                    cache: false,
                    data: {
                        '_token': _token,
                        'type_hot': type_hot,
                    },
                }).done(function(data) {
                    $('#overlay').hide();
                    $('.loading').hide();
                    if (data.message == "success") { 
                        $('#hot .list-hot').html(data.html);
                    }
                });
            });
        }
        if($('#new').length){
            $('#new .sec-title').on('change','select#hot-select',function(){
                var _token = $(this).attr('data-token');
                var link = $(this).attr('data-link');
                var type_hot = $(this).val();
                $('#overlay').show();
                $('.loading').show();
                $.ajax({
                    type: 'POST',
                    url: link,
                    cache: false,
                    data: {
                        '_token': _token,
                        'type_hot': type_hot,
                    },
                }).done(function(data) {
                    $('#overlay').hide();
                    $('.loading').hide();
                    if (data.message == "success") { 
                        $('#new .list-new').html(data.html);
                    }
                });
            });
        }
   }
});
//validate email
function validateEmail(email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test(email);
}
//formatCurrency
function formatMoney(number) {
    number = number || 0;
    places = 0;
    symbol = " ??";
    thousand = ".";
    decimal = ".";
    var negative = number < 0 ? "-" : "",
        i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "") + symbol;
}
function checkTodayThreeLetters(day) {
    var d = new Date();
    var days = ["sun","mon","tue","wed","thu","fri","sat"];
    return days[d.getDay()];
}
function getURLParameter(pageURL,paramUrl) {
    var pageURL = window.location.search.substring(1);
    var urlVariables = pageURL.split('&');
    for (var i = 0; i < urlVariables.length; i++) {
        var parameterName = urlVariables[i].split('=');
        if (parameterName[0] == paramUrl) {
            return parameterName[1];
        }
    }
}