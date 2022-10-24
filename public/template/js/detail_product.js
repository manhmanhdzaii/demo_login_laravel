$('.item_img_demo').on('click', function(){
    $('.item_img_demo').removeClass('item_img_demo_tick');
    $(this).addClass('item_img_demo_tick');
    $src = $('.main_img_show img').attr('src');
    $str_tick = $(this).children('img').attr('src');
    if($src != $str_tick){
        $('.main_img_show img').attr('src', $(this).children('img').attr('src'))
    }
})
$('.add_cart_summation').click(function(){
    var add = $('.add_cart_value').val();
    if(add==""){
        $('.add_cart_value').attr('value',1);
    }else{
       add = Number(add);
       add = add + 1;
        $('.add_cart_value').attr('value',add);
       
    }
    $('.add_cart_value').trigger("change");
})
$('.add_cart_subtraction').click(function(){
    var minus = $('.add_cart_value').val();
    if(minus==""| minus <= 1 ){
        $('.add_cart_value').attr('value',1);
    }else{
        minus = Number(minus);
        minus =minus - 1;
        $('.add_cart_value').attr('value',minus);
       
    }
    $('.add_cart_value').trigger("change");
})
$('.add_cart_value').change(function(){
    $value = $(this).val();
    $value = add = Number($value);
    $(this).attr('value',$value);
});