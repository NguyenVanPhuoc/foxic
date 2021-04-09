(function($) {
    'use strict';
    //drag & drop
    $(".sortable" ).sortable({			
        update: function(e, ui) {
            var count = 0;
            $(".sortable .ui-sortable-handle").each(function(){
                count = count + 1;
                $(this).attr("data-position",count);
            });
        }
    });
    //add record
    $(".sortable-items .add-row").click(function(){ 
        var recores = $(this).parents(".sortable-items").find(".sortable").attr("data-recores");
        var number = parseInt(recores) + 1;
        $(this).parents(".sortable-items").find(".sortable").attr("data-recores",number);
        // if($(this).parents(".sortable-items").find(".sortable .item").length > 0) {
        //     var item = $(this).parents(".sortable-items").find(".sortable .item").last().clone();
        //     var check = 1;
        // }else{
            var item = $(this).parents(".sortable-items").find(".att-temp .item").clone();
            var check = 0;
            item.find('input[name="attrValue"]').attr({'required':true, 'data-error':'최종 가격을 입력해주세요'}).addClass('mask-currency-add');
            item.find('.attr-value').append('<div class="help-block with-errors"></div>');
        // }
        item.find(".img-upload").attr("id","img-"+number);
        item.attr("data-position",number);    
        $(this).parents(".sortable-items").find(".sortable").append(item);
        $('.mask-currency-add[data-mask]').inputmask({
            alias: 'decimal',
            groupSeparator: ',',
            autoGroup: true,
            digits: 0,
            digitsOptional: false,
            suffix: ' 원',
            placeholder: '0',
            removeMaskOnSubmit: true,
        });
        return false;
    });
    //delete record   
    $(".sortable").on('click','i.fa-trash',function(){
        var recores = $(this).parents(".sortable-items").find(".sortable").attr("data-recores");
        var number = parseInt(recores) - 1;
        $(this).parents(".sortable-items").find(".sortable").attr("data-recores",number);	
        $(this).parents(".ui-sortable-handle").remove();
        var count = 0;
        $(".sortable .ui-sortable-handle").each(function(){
            count = count + 1;
            $(this).attr("data-position",count);
        });
    });
})(jQuery);