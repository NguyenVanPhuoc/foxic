$(document ).ready(function(){
    $('.scrollbar-inner').scrollbar();
    //edit media
    $("#edit-media .dev-form").on('click', '.group-action button',function(){
        var link = $(".dev-form").attr("action");
        var title = $(".dev-form #frm-title input").val();
        if(title==""){
            new PNotify({
                title: 'Lỗi',
                text: 'Vui lòng nhập tên file.',
                hide: true,
                delay: 6000,
            });
        }else{
            $(".dev-form").append('<div class="loading"><img src="'+location.protocol + "//" + location.host+'/public/images/loading_red.gif" alt="loading..."/></div>');
            return true;
        }
        return false;
    });    
    //edit profile
    $("#edit-profile .dev-form").on('click', '.group-action button',function(){
        var link = $(".dev-form").attr("action");
        var name = $(".dev-form #frm-name input").val();
        var phone = $(".dev-form #frm-phone input").val();
        var about = $(".dev-form #frm-about input").val();
        var address = $(".dev-form #frm-address input").val();
        if( name== ""){
            new PNotify({
                title: 'Lỗi',
                text: 'Vui lòng nhập họ & tên.',
                hide: true,
                delay: 6000,
            });
        }else{
            $(".dev-form").append('<div class="loading"><img src="'+location.protocol + "//" + location.host+'/public/images/loading_red.gif" alt="loading..."/></div>');
            return true;
        }
        return false;
    });
    //edit password
    $("#edit-password .dev-form").on('click', '.group-action button',function(){
        var link = $(".dev-form").attr("action");
        var oldPass = $(".dev-form #frm-oldPass input").val();
        var newPass = $(".dev-form #frm-newPass input").val();
        var conPass = $(".dev-form #frm-confirmPass input").val();
        var errors = new Array();
        var error_count = 0;
        if(oldPass=="") errors.push("Vui lòng nhập mật khẩu cũ.");
        if(newPass=="") errors.push("Vui lòng nhập mật khẩu mới.");
        if(conPass!=newPass) errors.push("Mật khẩu nhập lại không khớp.");
        var i;
        var html = "<ul>";
        for(i = 0; i < errors.length; i++){
            if(errors[i] != ""){
                html +='<li>'+errors[i]+'</li>';
                error_count += 1;
            }
        }
        html += "</ul>";
        if(error_count>0){
            new PNotify({
                title: 'Lỗi dữ liệu ('+error_count+')',
                text: html,
                hide: true,
                delay: 6000,
            });
        }else{ 
            $(".dev-form").append('<div class="loading"><img src="'+location.protocol + "//" + location.host+'/public/images/loading_red.gif" alt="loading..."/></div>')
            return true;
        }
        return false;
    });
    /**
     * dell select item
     */
    $("#check-all").click(function(){
        var number = 0;
        $(".dev-form table thead th").each(function(){
            number = number + 1;
        });
        if($(this).find("input").is(":checked")){
            $(".dev-form tbody .check input").prop("checked", true);
            $(".dev-form .table .show-btn").remove();
            $(".dev-form .table thead").after('<tbody class="show-btn text-center"><tr><td colspan="'+number+'"><button class="dell-all btn btn-cs">Xóa</button></td></tr></tbody>');
        }else{          
            $(".dev-form .dell-all").remove();
            $(".dev-form tbody .check input").prop('checked', false);
            $(".dev-form .table .show-btn").remove();
        }
    });
     $(".dev-form tbody .check").click(function(){
        var number = 0;
        $(".dev-form table thead th").each(function(){
            number = number + 1;
        });
        var items = new Array();
        $(".dev-form tbody tr").each(function(){
            if($(this).find(".check input").is(":checked")){
                items.push($(this).find("input").val());
            }
        });     
        if(items.length>0){
            $(".dev-form .dell-all").remove();
            $(".dev-form .table .show-btn").remove();
            $(".dev-form .table thead").after('<tbody class="show-btn text-center"><tr><td colspan="'+number+'"><button class="dell-all btn btn-cs">Xóa</button></td></tr></tbody>');
        }else{
            $(".dev-form .dell-all").remove();
            $(".dev-form .table .show-btn").remove();
        }
    });
    //delete media file
    $("#media .delete").click(function(){
        var href = $(this).attr("href");
        (new PNotify({
            title: 'Xóa',
            text: 'Bạn muốn xóa ảnh này?',
            icon: 'glyphicon glyphicon-question-sign',
            type: 'error',
            hide: false,
            confirm: {
                confirm: true
            },
            buttons: {
                closer: false,
                sticker: false
            },
            history: {
                history: false
            }
        })).get().on('pnotify.confirm', function() {
            window.location.href = href;
        });
        return false;
    });
    //delete media files are choose
    $("#media").on('click','.dell-all',function(){
        var _token = $("form input[name='_token']").val();
        var items = new Array();
        $(".dev-form tbody tr").each(function(){
            if($(this).find(".check input").is(":checked")){
                items.push($(this).find("input").val());
            }
        });
        if(items<0){
            new PNotify({
                title: 'Lỗi dữ liệu',
                text: 'Vui lòng chọn ít nhất 1 hàng cần xóa.!',
                hide: true,
                delay: 6000,
            });
        }else{
            $(".dev-form").append('<div class="loading"><img src="'+location.protocol + "//" + location.host+'/public/images/loading_red.gif" alt="loading..."/></div>');
            $.ajax({
                type:'POST',
                url:$("#media .dev-form").attr("action"),
                cache: false,
                data:{
                    '_token': _token,
                    'items': JSON.stringify(items)
                },
            }).done(function(data) {
                if(data=="success"){
                    $(".dev-form .loading").remove();
                    $(".dev-form tbody .check input").prop('checked', false);
                    $.each(items, function(index, value){
                        $(".dev-form #image-"+value).remove();
                    });
                    items = new Array();
                    new PNotify({
                        title: 'Thành công',
                        text: 'Xóa thành công.',
                        type: 'success',
                        hide: true,
                        delay: 2000,
                    });
                }else{
                    new PNotify({
                        title: 'Lỗi',
                        text: 'Trình duyệt không hỗ trợ javascript.',
                        hide: true,
                        delay: 2000,
                    });
                }
            });
        }
        return false;
    });    
    //media library pro-header
    $("#pro-header").on('click','#pro-banner',function(e){
        e.preventDefault();
        $("#library-op #file-detail").empty();
        var _token = $("#pro-header form input[name='_token']").val();
        var link = $("#pro-header form").attr("action");
        $("#library-op .modal-footer .btn-primary").addClass($(this).attr("id"));
        $.ajax({
            type:'POST',
            url:link,
            cache: false,
            data:{
                '_token': _token
            },
            success:function(data){ 
                if(data.message != 'error'){
                    $('#library-op .modal-body #files .list-media').html(data.html);
                    $("#library-op #files .limit").val(data.limit);
                    $("#library-op #files .current").val(data.current);
                    $("#library-op #files .total").val(data.total);
                    $("#library-op").modal('toggle');
                }else{
                    $("#library-op").modal('toggle');
                    $('#library-op .modal-body #files .list-media').html('<li>Không có file nào.</li>');
                }
            }
        })
        return false;
    });
    // media library avatar
    $(".avatar").on('click','#pro-picture',function(e){
        e.preventDefault();
        $("#library-op #file-detail").empty();
        var _token = $("form input[name='_token']").val();
        var link = $("#pro-header form").attr("action");
        var link2 = $(this).attr("data-route");
        $("#library-op .modal-footer .btn-primary").addClass($(this).attr("id"));
        $.ajax({
            type:'POST',
            url:link2,
            cache: false,
            data:{
                '_token': _token
            },
            success:function(data){
                if(data.message !='error'){
                    $('#library-op .modal-body #files .list-media').html(data.html);
                    $("#library-op #files .limit").val(data.limit);
                    $("#library-op #files .current").val(data.current);
                    $("#library-op #files .total").val(data.total);
                    $("#library-op").modal('toggle');
                }else{
                    $("#library-op").modal('toggle');
                }
            }
        })
        return false;
    });
    //load more media
    var total = 0;
    var current = 0;
    var limit = 0;
    $("#library-op #files").scroll(function(){
        var _token = $(".dev-form input[name='_token']").val();
        var s = $("#library-op #media-find input").val();
        total = parseInt($("#library-op #files .total").val());
        current = parseInt($("#library-op #files .current").val());
        limit = $("#library-op #files .limit").val();
        if(total>current){
            if($("#library-op #files").scrollTop() + $("#library-op #files").height()>= $("#library-op .list-media").height() + 10) {
                $.ajax({
                    type:'POST', 
                    url:$("#library-op .more-media").val(),
                    cache: false,
                    data:{
                        '_token': _token,
                        's': s,
                        'limit': $("#library-op #files .limit").val(),
                        'current': $("#library-op #files .current").val(),
                    },
                    success:function(data){
                        if(data!="error"){
                            total = data.total;
                            current = data.current
                            $('#library-op .modal-body #files .list-media').append(data.html);
                            $("#library-op #files .limit").val(data.limit);
                            $("#library-op #files .current").val(data.current);
                            $("#library-op #files .total").val(data.total);
                        }
                    }
                });
            }
        }
    });
    //detail media file
    $("#library-op .modal-body").on('click', '.list-media li', function(){
        $(".list-media li").removeClass("active");
        $(this).addClass('active');
        var img_link = $(".list-media li.active img").attr("data-image");
        var img_title = $(".list-media li.active img").attr("data-title");
        var img_alt = $(".list-media li.active img").attr("alt");
        var img_date = $(".list-media li.active img").attr("data-date");
        var img_id = $(".list-media li.active").attr("id").split("-");
        var html ="<div class='wrap'>";     
        html += "<h3>Thông tin file</h3>";
        html += "<img src='"+img_link+"' alt='"+img_alt+"' data-value='"+img_id[1]+"' class='thumb'/>";
        html +="<h4>"+img_title+"</h4>";
        html +="<p class='date'>"+img_date+"</p>";
        html +="<a href='#' class='delete' id='"+img_id[1]+"'>Xóa ảnh</a>";
        html +="</div>";
        $("#library-op #file-detail").html(html);
    });
    //change image
    $("#library-op .group-action").on('click','.btn-normal',function(){
        $("#library-op .modal-footer .library-notify").empty();
        var img_alt = $("#library-op #file-detail .thumb").attr("alt");
        var img_id = $("#library-op #file-detail .thumb").attr("data-value");
        var tag_id = $(this).attr("id");
        if(img_alt === undefined){  
            $("#library-op .modal-footer .library-notify").text("Vui lòng chọn file!!");
        }else{
            img_url = "/image/"+img_alt+"/168/138";
            $(".dev-form #"+ tag_id+ " .image > img").attr("src", img_url);
            $(".dev-form #"+ tag_id+ " .thumb-media").val(img_id);
            $("#library-op .group-action .btn-primary").removeClass("btn-normal");
            $("#library-op").modal('toggle');
            $(".modal-backdrop").modal('toggle');
        }
        return false;
    })
    //change banner profile  
    $("#library-op .group-action").on('click', '.pro-banner', function(){
        var _token = $("#library-op .tab-content #media input[name='_token']").val();
        var id = $("#file-detail .delete").attr("id");
        var link = $("#pro-header #pro-banner").attr("data-route");
        var url_img = $("#file-detail img").attr("src");
        if(id==""){
            new PNotify({
                title: 'Lỗi',
                text: 'Bạn chưa chọn ảnh!',
                hide: true,
                delay: 6000,
            });
        }else{
            $.ajax({
                type:'POST',
                url:link,
                cache: false,
                data:{
                    '_token': _token,
                    'id': id
                },
                success:function(data){
                    if(data.message != "error"){
                        $(".pro-avatar").attr("style","background-image:url("+url_img+")");
                        $("#library-op .group-action .btn-primary").removeClass("pro-banner");
                        $("#library-op").modal('toggle');
                        location.reload();
                    }else{
                       new PNotify({
                            title: 'Lỗi dữ liệu',
                            text: 'Bạn chưa chọn ảnh!',
                            hide: true,
                            delay: 6000,
                        }); 
                    }
                }
            });
        }
        return false;
    });
    // change avatar
    $("#library-op .group-action").on('click', '.pro-picture', function(){
        var _token = $("#library-op .tab-content #media input[name='_token']").val();
        var id = $("#file-detail .delete").attr("id");
        var link = $("#sidebar #pro-picture").attr("data-route");
        var title_img = $("#file-detail .thumb").attr("src");
        if(id == ""){
            new PNotify({
                title: 'Lỗi',
                text: 'Bạn chưa chọn ảnh!',
                hide: true,
                delay: 6000,
            });
        }else{
            $.ajax({
                type:'POST',
                url:link,
                cache: false,
                data:{
                    '_token': _token,
                    'id': id
                },
                success:function(data){
                    if(data.message != "error"){ 
                        title_img = "/image/"+title_img+"/174/174";
                        $(".pro-avatar .picture img").attr("src",title_img);
                        $("#library-op .group-action .btn-primary").removeClass("pro-picture");
                        $("#library-op").modal('toggle');
                        location.reload();
                    }else{
                       new PNotify({
                            title: 'Lỗi dữ liệu',
                            text: 'Bạn chưa chọn ảnh!',
                            hide: true,
                            delay: 6000,
                        }); 
                    }
                }
            })
        }
        return false;
    });
    //delete media
    $("#library-op #file-detail").on('click', '.delete', function(){
        var _token = $("#library-op .tab-content #media input[name='_token']").val();
        var id = $(this).attr("id");
        var link = $("#library-op .tab-content #media form").attr("action");
        $.ajax({
            type:'POST',
            url:link,
            cache: false,
            data:{
                '_token': _token,
                'id': id
            },
            success:function(data){
                if(data!="error"){
                    $("#library-op .modal-body #image-"+id).remove();
                    $("#library-op #file-detail").empty();
                    if(data!="success"){
                        $("#avatar img").attr("src", data);
                    }
                }
            }
        });
        return false;
    });
    $(document).on("click",".modal-body li a",function()
    {
        tab = $(this).attr("href");
        $(".modal-body .tab-content div").each(function(){
            $(this).removeClass("in active");
        });
        $(".modal-body .tab-content "+tab).addClass("in active");
    });
    //load version of game type
    $("#sb-categories .list-item a").click(function(){
        var _token = $("form.dev-form input[name='_token']").val();
        $.ajax({
            type:'POST',            
            url:location.protocol + "//" + location.host+'/tai-khoan/load-server-info',
            cache: false,
            data:{
                '_token': _token,
                'id': $(this).attr("data-value"),
                'aticle_id': $(".profile .frm-news").attr("data-value")
            },
        }).done(function(data) {
            if(data.message=="success"){
                $("#ct-server .game-info").html(data.html);
            }else{
                $("#ct-server .game-info").empty();
            }
        });
    })

    //create news
    $("#profile-createNews").on('click','.dev-form .group-action button',function(){
        var _token = $("form input[name='_token']").val();
        var title = $("#frm-title input").val();
        var content = CKEDITOR.instances['editor'].getData();
        var shortContent = $("#frm-shortContent textarea").val();
        var image = $("#frm-image input").val();
        var catId = $("#sb-categories .dropdown-toggle").attr("data-value");
        var alphaTest = $("#ct-server .alpha-test").val();
        var openBeta = $("#ct-server .open-beta").val();
        var errors = new Array();
        var error_count = 0;
        var server = parseInt($("#ct-server .game-info").attr('data-value'));
        var server_info = new Array();
        var count = 0;
        $(".game-info .item").each(function(){
            if($(this).find("input").val()!=""){
                server_info[count] = {
                    'meta_id' : $(this).find("input").attr('data-value'),
                    'meta_value' : $(this).find("input").val(),
                    'id' : $(this).find("input").attr('data-meta'),
                }
            count = count+1;
            }
        });
        if(title == "") errors.push("Vui lòng nhập tiêu đề.");
        if(catId == "") errors.push("Vui lòng chọn danh mục.");
        if(alphaTest == "") errors.push("Vui lòng ngày Alpha Test.");
        if(alphaTest == "") errors.push("Vui lòng ngày Open Beta.");
        var i;
        var html = "<ul>";
        for(i = 0; i < errors.length; i++){
            if(errors[i] != ""){
                html +='<li>'+errors[i]+'</li>';
                error_count += 1;
            }
        }
        html += "</ul>";
        if(error_count>0){
            new PNotify({
                title: 'Lỗi dữ liệu ('+error_count+')',
                text: html,
                hide: true,
                delay: 6000,
            });
        }else{
            $(".dev-form").append('<div class="loading load-fix"><img src="'+location.protocol + "//" + location.host+'/public/images/loading_red.gif" alt="loading..."/></div>')
            $.ajax({
                type:'POST',
                url:$("#profile-createNews .frm-news").attr("action"),
                cache: false,
                data:{
                    '_token': _token,
                    'title': title,
                    'content': content,
                    'shortContent': shortContent,
                    'image': image,
                    'catId': catId,
                    'alphaTest':alphaTest,
                    'openBeta':openBeta,
                    'serverInfo': JSON.stringify(server_info)
                },
            }).done(function(data) {
                $(".dev-form .loading").remove();
                if(data!="error"){
                    $(".article-op, .title-modal").remove();
                    $("#service-op .modal-body").prepend(data.html);
                    $("#overlay").show();
                    $("#service-op").show();
                }else{
                    new PNotify({
                        title: 'Lỗi',
                        text: 'Trình duyệt không hỗ trợ javascript.',
                        hide: true,
                        delay: 2000,
                    });
                }
            });
        }
    return false;
   });
   //edit blog
    $("#profile-editNews").on('click','form .group-action button',function(){
        var _token = $("form input[name='_token']").val();
        var title = $("#frm-title input").val();
        var content = CKEDITOR.instances['editor'].getData();
        var shortContent = $("#frm-shortContent textarea").val();
        var image = $("#frm-image input").val();        
        var catId = $("#sb-categories .dropdown-toggle").attr("data-value");
        var alphaTest = $("#ct-server .alpha-test").val();
        var openBeta = $("#ct-server .open-beta").val();
        var errors = new Array();           
        var error_count = 0;
        var server = parseInt($("#ct-server .game-info").attr('data-value'));
        var server_info = new Array();
        var count = 0;       
        $(".game-info .item").each(function(){
            if($(this).find("input").val()!=""){
                server_info[count] = {
                    'meta_id' : $(this).find("input").attr('data-value'),
                    'meta_value' : $(this).find("input").val(),
                    'id' : $(this).find("input").attr('data-meta'),
                }
            count = count+1;
            }
        });
        if(title=="") errors.push("Vui lòng nhập tiêu đề.");
        if(catId=="") errors.push("Vui lòng chọn danh mục.");
        var i;
        var html = "<ul>";
        for(i = 0; i < errors.length; i++){
            if(errors[i] != ""){
                html +='<li>'+errors[i]+'</li>';
                error_count += 1;
            }
        }
        html += "</ul>";
        if(error_count>0){
            new PNotify({
                title: 'Lỗi dữ liệu ('+error_count+')',
                text: html,
                hide: true,
                delay: 6000,
            });
        }else{
            $(".dev-form").append('<div class="loading load-fix"><img src="'+location.protocol + "//" + location.host+'/public/images/loading_red.gif" alt="loading..."/></div>');
            $.ajax({
                type:'POST',
                url:$("#profile-editNews .frm-news").attr("action"),
                cache: false,
                data:{
                    '_token': _token,
                    'title': title,
                    'content': content,
                    'shortContent': shortContent,
                    'image': image,
                    'catId': catId,
                    'alphaTest':alphaTest,
                    'openBeta':openBeta,
                    'serverInfo': JSON.stringify(server_info)
                },
            }).done(function(data) {
                $(".dev-form .loadding").remove();
                if(data.message!="error"){
                    window.location.href = location.protocol + "//" + location.host+'/tai-khoan/cam-on';
                }else{
                    new PNotify({
                        title: 'Lỗi',
                        text: 'Trình duyệt không hỗ trợ javascript.',
                        hide: true,
                        delay: 2000,
                    });
                }
            });
        }
    return false;
   });
    //delete blogs
    $("#profile-news .dev-form").on('click','.dell-all',function(){
        var _token = $(this).parents("form").find("input[name='_token']").val();
        var items = new Array();
        $(".dev-form tbody tr").each(function(){
            if($(this).find(".check input").is(":checked")){
                items.push($(this).find("input").val());
            }
        });     
        if(items<0){                
            new PNotify({
                title: 'Lỗi dữ liệu',
                text: 'Vui lòng chọn ít nhất 1 hàng cần xóa.!',
                hide: true,
                delay: 6000,
            });
        }else{
            $(".dev-form").append("<div class='loading'><img src='"+location.protocol + "//" + location.host+"/public/images/loading_red.gif' alt='loading..'/></div>");
            $.ajax({
                type:'POST',
                url:location.protocol + "//" + location.host+'/tai-khoan/delete-all',
                cache: false,
                data:{
                    '_token': _token,
                    'items': JSON.stringify(items)
                },
            }).done(function(data) {
                if(data=="success"){
                    window.location.href = $(".form-main").attr("action");
                }else{
                    new PNotify({
                        title: 'Lỗi',
                        text: 'Bạn không đủ quyền.',
                        hide: true,
                        delay: 2000,
                    });
                }
            });
        }
        return false;
    })
    //remove like
    $("#profile-like .likes a.unlike").click(function(){
        var value = parseInt($(this).attr("data-value"));        
        var _token = $("#profile-like .likes").attr("data-token");
        var id = $(this).attr("data-value");
        $(this).append('<img class="loading" src="'+location.protocol + "//" + location.host+'/public/images/loading_red.gif" alt="loading..."/>')
        $.ajax({
            type:'POST', 
            url:location.protocol + "//" + location.host+'/tai-khoan/delete-like',
            cache: false,
            data:{
                '_token': _token,
                'id': id
            },
        }).done(function(data) {
            if(data=="success"){$("#profile-like .likes #like-"+id).remove();}
        });
        return false;
    })
    //paymment card
    $("#fnapthe").on('click', '.group-action .btn-cs', function(){
        var _token = $(".dev-form input[name='_token']").val();
        var type = $("#fnapthe #frm-type select").val();
        var price = $("#fnapthe #frm-price select").val();
        var pin = $("#fnapthe #frm-pin input").val();
        var seri = $("#fnapthe #frm-seri input").val();
        var note = $("#fnapthe #frm-note textarea").val();
        var captcha = $("#fnapthe #frm-captcha input").val();
        var errors = new Array();
        var error_count = 0;        
        if(type=="") errors.push("Vui lòng chọn loại thẻ.");
        if(price=="") errors.push("Vui lòng chọn mệnh giá.");
        if(pin=="") errors.push("Vui lòng nhập mã thẻ.");
        if(seri=="") errors.push("Vui lòng nhập số seri.");
        if(captcha=="") errors.push("Vui lòng nhập mã bảo mật.");
        var i;
        var html = "<ul>";
        for(i = 0; i < errors.length; i++){
            if(errors[i] != ""){
                html +='<li>'+errors[i]+'</li>';
                error_count += 1;
            }
        }
        html += "</ul>";
        if(error_count>0){
            new PNotify({
                title: 'Lỗi dữ liệu ('+error_count+')',
                text: html,
                hide: true,
                delay: 6000,
            });
        }else{
            $.ajax({
                type:'POST',
                url:$("#fnapthe").attr("action"),
                cache: false,
                data:{
                    '_token': _token,
                    'type': type,
                    'price': price,
                    'pin': pin,
                    'seri': seri,
                    'note': note,
                    'captcha': captcha
                },
                beforeSubmit : function() {
                    $("#fnapthe").append('<div class="loading"><img src="'+location.protocol + "//" + location.host+'/public/images/loading_red.gif" alt="loading..."/></div>');
                },
                success:function(data){
                    $("#fnapthe .loading").remove();
                    console.log(data);
                    if(data.code==0){
                        new PNotify({
                            title: 'Thành công',
                            text: data.msg,
                            type: 'success',
                            hide: true,
                            delay: 2000,
                        });
                        setTimeout(function(){window.location.href = location.protocol + "//" + location.host+'/tai-khoan/payment-success'}, 500); 
                    }else{
                        new PNotify({
                            title: 'Lỗi dữ liệu',
                            text: data.msg,
                            type: 'error',
                            hide: true,
                            delay: 5000,
                        });
                        $.ajax({
                            type: "GET",
                            url: '/ajax_regen_captcha',
                        }).done(function( msg ) {
                             $("#frm-captcha input").val('');
                            $("#frm-captcha .input-group-addon img").attr('src', msg);
                        });
                    }
                }
            })
        }
        return false;
    });
    //tooltop service popup
    $(".service-op .item i.fa-question-circle").click(function(){
        $(".service-op .item").removeClass("sv-tip");
        $(".service-op .tip-con").remove();
        var html = $(this).parents(".item").find(".desc").html();
        $(this).parents(".item").toggleClass("sv-tip");
        if($(this).parents(".item").hasClass("sv-tip")){
            $(".service-op .list-service").after('<div class="tip-con"></div>');
            $(".service-op .tip-con").html(html);
            $(".service-op .tip-con").show();
        }
    });
    $(".service-op .item i.fa-times-circle").click(function(){
        $(".service-op .list-service .tip-con").remove();
    });
    //hide popup services
    $(".service-op").on('click','.tip-con .fa-times-circle',function(){
        $(".service-op .item").removeClass("sv-tip");
        $(".service-op .tip-con").remove();
    });
    //load meta packages
    $(".service-op .item .sv-overlay").click(function(){
        var _token = $("#service-op form input[name='_token']").val();
        var total = 0;
        var count = 0;        
        var package_ids = new Array();
        var meta_ids = new Array();
        $(this).parents(".item").toggleClass("active");
        if($(this).parents(".item").hasClass("active")){
            $(this).parents(".item").find(".wrap").prepend('<i class="fas fa-check-circle"></i>');
        }else{
            $(this).parents(".item").find(".fa-check-circle").remove()
        }
        $(".service-op .list-service .item").each(function(){
            var package_id = $(this).attr("data-value");
            var meta_id = $(this).attr("data-meta");
            if($(this).hasClass("active")){
                package_ids[count] = {
                    'meta_title' : $(this).find(".middle .title").text(),
                    'meta_unit' : $(this).find(".middle .time").attr("data-unit"),
                    'meta_id' : meta_id,
                    'package_id' : package_id,
                };
                count = count+1;
            }else{
                $(this).find(".fa-check-circle").remove();
                $("#service-op .metas-packages #pak-"+package_id).remove();
            }
        });
        $(".service-op .metas-packages .box").each(function(){
            meta_ids.push($(this).find('.list .mt-active').attr('data-id'));
        });
        $.ajax({
            type:'POST',
            url:location.protocol + "//" + location.host+'/tai-khoan/metas-package',
            cache: false,
            data:{
                '_token': _token,
                'package_ids': JSON.stringify(package_ids),
                'meta_ids': JSON.stringify(meta_ids),
            },
        }).done(function(data) {
            if(data.message!="error"){
                $("#service-op .metas-packages").html(data.html);
                var html ='<a href="#" data-value="'+data.meta_ids+'" class="btn-normal btn-payment">'+data.total+' - Thanh toán ngay</a>';
                $(".service-op .group-action .btn-payment").remove();
                $(".service-op .group-action").prepend(html);
            }else{
                $("#service-op .metas-packages").empty();
                $("#service-op .btn-payment").remove();
            }
        });
    });
    //load price
    $(".service-op").on('click','.metas-packages .list li',function(){
        var packages = new Array();        
        var parent = $(this).parent(".list").attr("id");
        var package_id = $(this).parent(".list").attr('data-value');
        var meta_id = $(this).attr('data-id');
        $('#'+parent+' li').removeClass('mt-active');
        $(this).addClass('mt-active');
        $(".service-op .metas-packages .box").each(function(){           
            packages.push($(this).find('.list .mt-active').attr('data-id'));
        });          
        var _token = $("#service-op form input[name='_token']").val();
        $.ajax({
            type:'POST',
            url:location.protocol + "//" + location.host+'/tai-khoan/canculate-metas',
            cache: false,
            data:{
                '_token': _token,
                'meta_id': meta_id,
                'packages': JSON.stringify(packages),
            },
        }).done(function(data) {
            if(data.message!="error"){
                $("#service-op .list-service #package-"+package_id).attr('data-meta', meta_id);
                $("#service-op #package-"+package_id+" .middle .time").text(data.time+' '+data.unit);
                $("#service-op #package-"+package_id+" .middle .price .sale").attr('data-value',data.price);
                $("#service-op #package-"+package_id+" .middle .price .sale").html(data.price_text);
                var html ='<a href="#" data-value="'+packages.toString()+'" class="btn-normal btn-payment">'+data.total+' - Thanh toán ngay</a>';
                $(".service-op .group-action .btn-payment").remove();
                $(".service-op .group-action").prepend(html);
            }
        });
    });
    //hide popup service
    $("#profile-createNews #service-op").on('click','.close',function(){        
        window.location.href = location.protocol + "//" + location.host+'/tai-khoan/cam-on';
    });
    //payment service news
    $("#service-op").on('click','.group-action .btn-payment',function(){
        var _token = $("form input[name='_token']").val();
        var meta_ids = $(this).attr("data-value");
        $(this).append('<img class="loading" src="'+location.protocol + "//" + location.host+'/public/images/loading_red.gif" alt="loading..."/>');
        $.ajax({
            type:'POST',            
            url:$(".service-form").attr("action"),
            cache: false,
            data:{
                '_token': _token,
                'meta_ids': meta_ids,
                'article_id': $(".article-op").attr("data-post")
            },
        }).done(function(data) {
            if(data!="error"){ window.location.href = location.protocol + "//" + location.host+'/tai-khoan/cam-on';}
        });
        return false;
    });
    //vip news
    $(".btn-renewal").click(function(){
        $(".article-op, .title-modal").remove();
        var id = $(this).attr("data-post");
        var title = $(this).parents("tr").find(".title").text();
        var img_url = $(this).parents("tr").find(".image a").attr("data-img");
        var html ='<div class="article-op" data-post="'+id+'">';
        html += '<img src="'+img_url+'" alt="'+title+'">';
        html +='<h5>'+title+'</h5>';
        html +='</div>';
        $("#service-op .modal-body").prepend(html);
        $("#service-op").modal("toggle");
        return false;
    });

    // add class active menu 
    if($('#pro-main .pro-menu li a').hasClass('active')){
        $('.pro-asMenu .action .news a').addClass('active');
    }

    /*
    * filter order
    */
    $('form[name=filter-order]').submit(function(e){
        //e.preventDefault();
        var date_from = $(this).find('input[name=date_from]').val();
        var date_to = $(this).find('input[name=date_to]').val();
        if(date_from != '' || date_to != '')
            return true;
        return false;
    });

    // cancel order
    $('#orders .action .delete').click(function(e){

        /*new PNotify({
                    title: 'Lỗi',
                    text: 'Hệ thống đang có sự cố. Vui lòng thử lại sau.',
                    type: 'error',
                    hide: true,
                    delay: 2000,
                });
        return false;
        */
        var href = $(this).attr("href");
        (new PNotify({
            title: 'Xóa',
            text: 'Bạn muốn hủy đơn hàng này?',
            icon: 'glyphicon glyphicon-question-sign',
            type: 'error',
            hide: false,
            confirm: {
                confirm: true
            },
            buttons: {
                closer: false,
                sticker: false
            },
            history: {
                history: false
            }
        })).get().on('pnotify.confirm', function() {
            window.location.href = href;
        });
        return false;
    });
    if($('#infoDetail-profile').length){
        $('#frm-phone input, #frm-phone_instructor_first input, #frm-phone_instructor_second input').inputmask('0999999999');
        $('#frm-home_phone input').inputmask('02999999999');
        $('#frm-year_started_work input, #frm-year_another_graduated input, #frm-year_appointments_instructor_first input, #frm-year_appointments_instructor_second input').inputmask('9999');
        $('#frm-date_birth input, #frm-date_issue input, #frm-date_graduated input, #frm-date_high_school_graduated input').inputmask();
        $('#frm-conduct_class_10 .cs-select, #frm-conduct_class_11 .cs-select, #frm-conduct_class_12 .cs-select').select2({
            placeholder: "Chọn xếp loại hạnh kiểm",
            allowClear: true,
            language: {
                noResults: function (params) {
                return "Không có kết quả";
                }
            }
        });
        if($(window).width() > 1024){
            $(".img-upload").on('click','.library',function(e){
                e.preventDefault();
                $("#library-op #file-detail").empty();
                var _token = $("form input[name='_token']").val();
                var link = $("#pro-header form").attr("action");
                var link2 = $(this).attr("href");
                var id = $(this).parents(".img-upload").attr("id");
                $("#library-op .modal-footer .btn-primary").addClass("btn-normal").attr("id",id);
                $('#overlay').show();
                $('.loading').show();
                $.ajax({
                    type:'POST',
                    url:link2,
                    cache: false,
                    data:{
                        '_token': _token
                    },
                    success:function(data){
                        $('#overlay').hide();
                        $('.loading').hide();
                        if(data.message != 'error'){
                            $('#library-op .modal-body #files .list-media').html(data.html);
                            $("#library-op #files .limit").val(data.limit);
                            $("#library-op #files .current").val(data.current);
                            $("#library-op #files .total").val(data.total);
                            $("#library-op").modal('toggle');
                        }else{
                            $('#library-op .modal-body #files .list-media').html('<li>Không có file nào.</li>');
                            $("#library-op").modal('toggle');
                        }
                    }
                })
                return false; 
            });
        }
        $('#frm-place_birth').on('change','select', function(){
            if($(this).val() == '65'){
                $html = '';
                $html += '<label for="country_other" class="control-label">Quốc gia<small>(*)</small></label>';
                $html += ' <input type="text" name="country_other" id="country_other" class="form-control">';
                $('#frm-country_other').append($html);
            }else{
                $('#frm-country_other').html('');
            }
        });
        $('#infoDetail-profile').on('click','form .group-action .btn-send',function(e){
            e.preventDefault();
            var link = $('#infoDetail-profile .dev-form').attr('action');
            $("#overlay").show();
            $('.loading').show();
            // console.log(link, $(this).closest('#infoDetail-profile').find('.dev-form').serialize());
            $.ajax({
                type:'POST',
                url: link,
                cache: false,
                data: $(this).closest('#infoDetail-profile').find('.dev-form').serialize(),
            }).done(function(data) {
                $("#overlay").hide();
                $('.loading').hide();
                if(data.error != undefined && data.error != ''){ 
                    var count = 0;
                    //remove class error
                    $('.form-group').removeClass('has-error has-danger').find('.with-errors').remove();
                    errors = data.error; 
                    $.each(errors, function( index, value ) { count++;
                        array = value;
                        $('[name='+ index +']').closest('.form-group').addClass('has-error has-danger')
                        .append('<div class="help-block with-errors"><ul class="list-unstyled"><li>'+array+'</li></ul></div>');
                        if(count == 1){ 
                            //scroll to first item error
                            $("html, body").animate({ scrollTop: $('[name='+ index +']').closest('.form-group').offset().top }, 1000);
                        }
                    });
                }
                else if(data.message != "error"){ 
                    new PNotify({
                        title: 'Thành công',
                        text: 'Cập nhật thông tin chi tiết thành công',
                        type: 'success',
                        hide: true,
                        delay: 2000,
                    });
                    location.reload();
                }
                else{
                    new PNotify({
                        title: 'Lỗi',
                        text: 'Server đang bận. Bạn vui lòng thử lại lần sau.',
                        type: 'error',
                        hide: true,
                        delay: 2000,
                    });
                }
            });
        });
    }
});