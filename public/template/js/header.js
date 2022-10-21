

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$('.header_menu').click(function(){
    $('.header_sub').removeClass('hidden');
})
$('.header_sub_arrow').click(function(){

    if($('.header_sub_title').hasClass('hidden') == true){
             $('.header_sub').addClass('hidden');
    }else{
        $('.header_sub_title').addClass('hidden');
        $('.header_sub_box2').addClass('hidden');
        $('.header_sub_box1').removeClass('hidden');
    }
})

$('.h_sub_b1_item_shop').click(function(){
    $('.header_sub_box1').addClass('hidden');
    $('.header_sub_box2').removeClass('hidden');
    $('.header_sub_title').removeClass('hidden');
})

$('.logout_home').click(function(){
    $.ajax({
        url: "/home/logout",
        type: 'post',
        dataType: "json",
        async: false,
        data:{},
        success: function(result) {
          window.location.reload();
        },
        
    });
})
