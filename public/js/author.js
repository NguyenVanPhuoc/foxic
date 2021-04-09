$(document ).ready(function(){
    //login
    $(".login-form").on('click', '#frm-submit .btn',function(){
        var errors = new Array();
        var error_count = 0;
        var _token = $(".login-form input[name='_token']").val(); 
        var link = $(".login-form").attr("action");
        var pass = $(".login-form #frm-pass input").val();
        var email = $(".login-form #frm-email input").val();
        if(pass == "") errors.push("Please enter a password!");
        if(email == "" || validateEmail(email)==false) errors.push("Email invalidate!");
        var i;
        var html = "<ul>";
        for(i = 0; i < errors.length; i++){
            if(errors[i] != ""){
                html +='<li>'+errors[i]+'</li>';
                error_count += 1;
            }
        }
        if(error_count>0){
            html += "</ul>";
            new PNotify({
                title: 'Errors ('+error_count+')',
                text: html,
                hide: true,
                delay: 6000,
            });
        }else{
            $('#overlay').show();
            $('.loading').show();
            $.ajax({
                type:'POST',
                url:link,
                cache: false,
                data:{
                    '_token': _token,
                    'pass': pass,
                    'email': email
                },
            }).done(function(data) {
                $('#overlay').hide();
                $('.loading').hide();
                if(data.message == "success"){
                    window.location.href = data.url;
                }else{
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
	//register
	$(".register-frm").on('click', '#frm-submit .btn',function(){
        var errors = new Array();
        var error_count = 0;
        var _token = $(".register-frm input[name='_token']").val(); 
        var link = $(".register-frm").attr("action");       
        var name = $(".register-frm #frm-name input").val();
        var email = $(".register-frm #frm-email input").val();
        var pass = $(".register-frm #frm-pass input").val();
        var passConfirm = $(".register-frm #frm-passConfirm input").val();
        var captcha = $(".register-frm #frm-captcha input").val();
        if(name=="") errors.push("Please enter your full name!");
        if(email=="" || validateEmail(email)==false) errors.push("Email invalidate!");
        if(pass=="") errors.push("Please enter a password!");
        if(passConfirm == "" || passConfirm != pass) errors.push("The re-entered password does not match!");
        if(captcha == "") errors.push("Please enter captcha!")
        var i;
        var html = "<ul>";
        for(i = 0; i < errors.length; i++){
            if(errors[i] != ""){
                html +='<li>'+errors[i]+'</li>';
                error_count += 1;
            }
        }
        if(error_count>0){
            html += "</ul>";
            new PNotify({
                title: 'Errors ('+error_count+')',
                text: html,
                hide: true,
                delay: 6000,
            });
        }else{
            $('#overlay').show();
            $('.loading').show();
            $.ajax({
                type:'POST',
                url:link,
                cache: false,
                data:{
                    '_token': _token,
                    'name': name,
                    'email': email,
                    'pass': pass,
                    'captcha': captcha,
                },
            }).done(function(data) {
                $('#overlay').hide();
                $('.loading').hide();
                if(data.message == "success"){
                    new PNotify({
                        title: 'Success',
                        text: 'Congratulations on your successful registration!',
                        type: 'success',
                        hide: true,
                        delay: 2000,
                    });
                    setTimeout(function(){
                        window.location.href = location.protocol + "//" + location.host+'/login';
                    }, 500);
                }else{
                    new PNotify({
                        title: 'Error',
                        text: printErrorMsg(data.error),
                        type: 'error',
                        hide: true,
                        delay: 2000,
                    });
                }
            });
        }   
        return false;
    });
    //captcha
    $('#frm-captcha').on('click','i.fa-sync-alt',function(e){
        e.preventDefault(); 
        var anchor = $(this);
        var captcha = anchor.prev('img');
        $.ajax({
            type: "GET",
            url: '/ajax_regen_captcha',
        }).done(function( msg ) {
            captcha.attr('src', msg);
        });
    });
});
//print errors
function printErrorMsg (msg) {
    var html = "<ul>";
    $.each( msg, function( key, value ) {
        html +='<li>'+value+'</li>';
    });
    html +="</ul>";
    return html;
}
//validate email
function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
}