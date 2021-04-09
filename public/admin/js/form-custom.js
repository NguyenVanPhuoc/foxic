$(document ).ready(function(){	
    var form_data = new FormData();
    var myDropzone;
    if($('#uploadSingleFile').length){
        var link = $("form").attr('action');
        Dropzone.options.uploadSingleFile = {
            autoProcessQueue: true,
            parallelUploads: 1,
            maxFilesize: 300,
            maxFiles:1,
            dictFallbackText: 'Upload file',
            autoProcessQueue: false,
            addRemoveLinks: true,
            dictCancelUpload: true,
            dictRemoveFile: '<i class="fas fa-times-circle"></i>',
            url: '#',
            init: function () {
                var myDropzone = this;
                this.on("thumbnail", function(file, dataUrl) {
                    $('.dz-image').last().find('img').attr({width: '100%', height: '100%'});
                });
                this.on('sending', function(file, xhr, formData) {
                    var data = $('#uploadSingleFile').serializeArray();
                    formData.append('category', name);
                $.each(data, function(key, el) {
                        formData.append(el.name, el.value);
                    });

                if(file.size > 307200){ //3kb
                        this.removeFile(file); 
                        PNotify.removeAll();
                        new PNotify({
                            title: "Error file",
                            text: "File size should < 300KB.",
                            hide: true,
                            delay: 3000
                        });
                    }
                    //check format image
                    var file_type = file.type;
                    if(file_type.indexOf('image') == -1){
                        this.removeFile(file); 
                        PNotify.removeAll();
                        new PNotify({
                            title: "Error file",
                            text: "The file is not formatted correctly.",
                            hide: true,
                            delay: 3000
                        });
                    }
                });
                this.on("uploadprogress", function(file, progress) { 
                    console.log(file);
                });
                this.on("error", function(file, message) { 
                    //
                });
                this.on("success", function(file, message) { 
                    form_data.append('file_1', file); 
                    $('#frmImage2').css('display', 'inline-block');
                    $('#frmImage2').removeClass('hide');
                });
                
            }
        }
    }    
    $('form.activity-form').submit(function(e){
        e.preventDefault();
        for ( instance in CKEDITOR.instances )
            CKEDITOR.instances[instance].updateElement();
        var link = $(this).attr('action'); 
        var form_normal = $(this).serialize(); 
        if($('#uploadSingleFile').length){ 
            var _token = $('input[name=_token]').val();
            var dataArray = $(this).serializeArray(); 
            $(dataArray).each(function(i, field){
                form_data.append(field.name, field.value);
            });

            $('#overlay').show();
            $('.loading').show();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                type: 'POST',
                url: link,
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                beforeSend: function () {
                    $('#overlay').show();
                    $(".loading").show(); 
                },
                success: function (data) {
                    $('#overlay').hide();
                    $('.loading').hide();
                    if(data.error) {
                        var errors = data.error;
                        var i;
                        var error_count = 0;
                        var html = '<ul>';
                        for(i = 0; i < errors.length; i++){
                            if(errors[i] != ""){
                                html +='<li>'+errors[i]+'</li>';
                                error_count += 1;
                            }
                        }
                        html += '</ul>';

                        if(error_count>0){ 
                            new PNotify({
                                title: 'Lỗi ('+error_count+')',
                                text: html,
                                hide: true,
                                delay: 4000,
                            });
                        }
                    }
                    else{
                        new PNotify({
                            title: 'Thành công',
                            text: data.success,
                            type: 'success',
                            hide: true,
                            delay: 4000,
                        });
                        if(data.url){
                            setTimeout(function(){
                                window.location.href = data.url;
                            }, 1000);
                        }
                    }
                }
            });
        }
        else{
            $('#overlay').show();
            $('.loading').show();
            $.ajax({
                url: link,
                type: "POST",
                data: form_normal,
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                dataType: "json",
                success: function (data) { 
                    $('#overlay').hide();
                    $('.loading').hide();
                    if(data.error) {
                        var errors = data.error;
                        var i;
                        var error_count = 0;
                        var html = '<ul>';
                        for(i = 0; i < errors.length; i++){
                                if(errors[i] != ""){
                                html +='<li>'+errors[i]+'</li>';
                                error_count += 1;
                            }
                        }
                        html += '</ul>';
                        if(error_count>0){ 
                            new PNotify({
                                title: 'Lỗi ('+error_count+')',
                                text: html,
                                hide: true,
                                delay: 4000,
                            });
                        }
                    }
                    else if(data.html != undefined){
                        $('#tb-result').html(data.html);
                    }
                    else{
                        new PNotify({
                            title: 'Thành công',
                            text: data.success,
                            type: 'success',
                            hide: true,
                            delay: 4000,
                        });
                        if(data.url){
                            setTimeout(function(){
                                window.location.href = data.url;
                            }, 1000);
                        }
                    }
                },
                error: function (data) {
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors, function (key, value) {
                        console.log(data.responseText);
                    });
                }
            });
        }
        return false;
    });

    $('form.activity-s-form').submit(function(e){
        e.preventDefault();
        $('#overlay').show();
        $('.loading').show();
        $.ajax({
            url: $(this).attr('action'),
            type: "GET",
            data: $(this).serialize(),
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            dataType: "json",
            success: function (data) { 
                $('#overlay').hide();
                $('.loading').hide();
                if(data.html != undefined){
                    $('#tb-result').html(data.html);
                }
            },
            error: function (data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors, function (key, value) {
                    console.log(data.responseText);
                });
            }
        });
    });

    $('form.activity-s-form').on('click', '.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr("href").split("page=")[1];
        var link = $(this).closest('form').attr('action');
        $('#overlay').show();
        $('.loading').show();
        $.ajax({
            url: link,
            type: "GET",
            data: $(this).closest('form').serialize()+'&page='+page,
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            dataType: "json",
            success: function (data) { 
                $('#overlay').hide();
                $('.loading').hide();
                if(data.html != undefined){
                    $('#tb-result').html(data.html);
                }
            },
            error: function (data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors, function (key, value) {
                    console.log(data.responseText);
                });
            }
        });
    });
});