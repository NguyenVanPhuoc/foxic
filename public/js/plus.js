$(document ).ready(function(){
    $(".bell").on('click', '.toggle-bell', function() {
        $(this).siblings('.dropdown-bell').addClass('show');
    });
    $(document).mouseup(function(e) {
        var container = $(".bell");
        if (!container.is(e.target) && container.has(e.target).length === 0 ) 
        {    
            $(".bell .dropdown-bell").removeClass('show');
        }
    });
    //back to top
    if($('#backtotop').length > 0){
        $(window).scroll(function() {
            if($(window).scrollTop() >200) {
                $('#backtotop').fadeIn();
                } else {
                $('#backtotop').fadeOut();
                }
            });
        $('#backtotop').click(function() {
            $('html, body').animate({scrollTop:0},500);
        });
    };
    $(".dropdown-avatar").on('click', '.avatar', function() {
        $(this).siblings('.dropdown-profile').addClass('show');
    });
    $(document).mouseup(function(e) {
        var container = $(".dropdown-avatar");
        if (!container.is(e.target) && container.has(e.target).length === 0 ) 
        {    
            $(".dropdown-avatar .dropdown-profile").removeClass("show")
        }
    });
    $('.scrollbar-inner').scrollbar();
    $(".list-book").on('click', '.see_more', function() {
        $(this).siblings('.list-chapters').addClass('more');
        $(this).hide();
    });
    $('.check').change(function(){
        if($('.check').is(':checked')){
            var id = $(this).attr('data-id');
            $(".purchase-list").find('.coin-list').not($('.check'+id)).addClass('hidden');
            $(".purchase-list").find('.coin-list.check'+id).removeClass('hidden');
            $(".purchase-list").find('.title').not($('.check'+id)).addClass('hidden');
            $(".purchase-list").find('.title.title'+id).removeClass('hidden');
        }
    });
    $(".list-chapters").on('click', '.chaps-number', function() {
        $("#chapsNumber").modal("show");
    });
    $("#modal_master").on('click', '.btn-close', function() {
        $("#modal_master").removeClass("show in");
    });
    $(".list-chapters").on('click', '.rent-chaps', function() {
        var $id = $(this).attr("data-id");
        var $rental = $(this).attr("rental");
        $("#rentChaps").find('input[name=chap_id]').val($id);
        $("#rentChaps").find('input[name=rental]').val($rental);
        $("#rentChaps").modal("show");
    });
    $('#rentChaps').on('click','.btn-success',function(){
        var link = $(this).parents('#rentChaps').attr('data-link');
        var _token = $(this).parents('#rentChaps').find("input[name='_token']").val();
        var chap_id = $(this).parents('#rentChaps').find('input[name=chap_id]').val();
        var rental = $(this).parents('#rentChaps').find('input[name=rental]').val();
        $('.loading').show();
        $.ajax({
            type: 'POST',
            url: link,
            cache: false,
            data: {
                '_token': _token,
                'chap_id': chap_id,
                'rental': rental,
            },
        }).done(function(data) {
           window.location.reload();
            $("#rentChaps").modal("hide");
            $('.loading').hide();
        });
    });
    $(".list-chapters").on('click', '.modal-point', function() {
        $("#numberPoint").modal("show");
    });
    $(".list-chapters").on('click', '.buy-chaps', function() {
        var $id = $(this).attr("data-id");
        var $point = $(this).attr("point");
        $("#buyChaps").find('input[name=chap_id]').val($id);
        $("#buyChaps").find('input[name=point]').val($point);
        $("#buyChaps").modal("show");
    });
    $('#buyChaps').on('click','.btn-success',function(){
        var link = $(this).parents('#buyChaps').attr('data-link');
        var _token = $(this).parents('#buyChaps').find("input[name='_token']").val();
        var chap_id = $(this).parents('#buyChaps').find('input[name=chap_id]').val();
        var point = $(this).parents('#buyChaps').find('input[name=point]').val();
        $('.loading').show();
        $.ajax({
            type: 'POST',
            url: link,
            cache: false,
            data: {
                '_token': _token,
                'chap_id': chap_id,
                'point': point,
            },
        }).done(function(data) {
            window.location.reload();
            $("#buyChaps").modal("hide");
            $('.loading').hide();
        });
    });
    if($('.read-next').length > 0) {
        var chap_id = localStorage.getItem($('.read-next').attr('data'));
        var link = $('.read-next').attr('action');
        var comic_id = $('.read-next').attr('data');
        var _token = $('.read-next').find("input[name='_token']").val();
        var parents = $('.read-next');
        
            $.ajax({
                type: 'POST',
                url: link,
                cache: false,
                data: {
                    '_token': _token,
                    'comic_id': comic_id,
                    'chap_id': chap_id,
                },
            }).done(function(data) {
                parents.html(data.html);
                $('.loading').hide();
            });
        
    }
    $('.list-xu').on('click','.btn-change-xu',function(){
        var id = $(this).attr('data-id');
        var link = $(this).parents('.list-xu').attr('data-link');
        var _token = $(this).parents('.tab-content').find("input[name='_token']").val();
        var parents = $('.tab-content');
        $('.loading').show();
        $.ajax({
            type: 'POST',
            url: link,
            cache: false,
            data: {
                '_token': _token,
                'id': id,
            },
        }).done(function(data){
            parents.before(data.html);
            $('.loading').hide();
        });
    });
    $('.list-point').on('click','.btn-change-point',function(){
        var id = $(this).attr('data-id');
        var link = $(this).parents('.list-point').attr('data-link');
        var _token = $(this).parents('.tab-content').find("input[name='_token']").val();
        var parents = $('.tab-content');
        $('.loading').show();
        $.ajax({
            type: 'POST',
            url: link,
            cache: false,
            data: {
                '_token': _token,
                'id': id,
            },
        }).done(function(data){
            parents.before(data.html);
            $('.loading').hide();
        });
    });
    //điểm danh
    $('header .top').on('click','.btn-muster',function(){
        var link = $(this).parents('header .top').attr('data-link');
        var _token = $(this).parents('.muster').find("input[name='_token']").val();
        $.ajax({
            type: 'POST',
            url: link,
            cache: false,
            data: {
                '_token': _token,
            },
        }).done(function(data){
            if (data.check == 1) { 
                alert("Chúc mừng! Bạn đã hoàn thành nhiệm vụ +2 xu.");
            }else{
                alert("Hôm nay bạn đã điểm danh! Vui lòng quay lại vào ngày mai.");
            }
            if(data.link!='') {
                window.location.href = data.link;
            }
        });
    });
    $('.btn-donate').mouseover(function(){
        $('.popover').addClass('active');
    });
    $(document).mouseup(function(e) {
        var container = $(".donate-vnp");
        if (!container.is(e.target) && container.has(e.target).length === 0 ) 
        {    
            $(".donate-vnp .popover").removeClass("active")
        }
    });
    //donate
    $('.donate-vnp').on('click','.btn-donate-nvp',function(){
        var link = $(this).parents('.donate-vnp').attr('data-link');
        var comic_id = $(this).attr('comic-id');
        var point = $(this).parents('.donate-vnp').find("input[type='number']").val();
        var _token = $(this).parents('.donate-vnp').find("input[name='_token']").val();
        $('.loading').show();
        $.ajax({
            type: 'POST',
            url: link,
            cache: false,
            data: {
                '_token': _token,
                'point': point,
                'comic_id': comic_id,
            },
        }).done(function(data){
            if (data.check == 1) {
                window.location.reload();
                $('.loading').hide();
            }else{
                window.location.reload();
            }
        });
    });
})