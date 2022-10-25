$('.btn_type').click(function(){
    if($(this).hasClass('btn_show')){
        $(this).toggleClass('btn_show');
        $(this).toggleClass('btn_hidden');
        $(this).html('Thu gọn');
        $(this).parent('.btn_view').parent('.info_order').next('.table_cart').removeClass('hidden');
    }else{
        $(this).toggleClass('btn_show');
        $(this).toggleClass('btn_hidden');
        $(this).html('Xem chi tiết');
        $(this).parent('.btn_view').parent('.info_order').next('.table_cart').addClass('hidden');
    }
})