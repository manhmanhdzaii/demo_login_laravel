$('.count_add').click(function(){
    var add = $(this).parents('.amount_product').children('input').val();
    if(add==""){
        $(this).parents('.amount_product').children('input').attr('value',1);
    }else{
       add = Number(add);
       add = add + 1;
     
        $(this).parents('.amount_product').children('input').attr('value',add);
    }
})
$('.count_minus').click(function(){
    var minus = $(this).parents('.amount_product').children('input').val();
    if(minus==""| minus <= 1 ){
        $(this).parents('.amount_product').children('input').attr('value',0);
        $(this).parents('tr').remove();
    }else{
        minus = Number(minus);
        minus =minus - 1;
        $(this).parents('.amount_product').children('input').attr('value',minus);
    }
})

$('.img_delete').click(function(){
    $(this).parents('tr').remove();
})