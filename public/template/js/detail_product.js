$('.item_img_demo').on('click', function(){
    $src = $('.main_img_show img').attr('src');
    $str_tick = $(this).children('img').attr('src');
    if($src != $str_tick){
        $('.main_img_show img').attr('src', $(this).children('img').attr('src'))
    }
})