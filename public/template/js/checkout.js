// $('.button_buy').click(function(){
//     $('.popup__all').toggleClass('hidden');
// })

$("#checkout").validate({
    onfocusout: false,
    onclick: false,
    rules: {
        "name": {
            required: true,
        },
        "email": {
            required: true,
            email: true,
        },
        "phone": {
            required: true,
        },
        "city": {
            required: true,
        },
    },
    messages: {
        "name": {
            required: "Tên không được để trống",
        },
        "email": {
            required: "Email không được để trống",
            email: "Chưa đúng định dạng email",
        },
        "phone": {
            required: "Số điện thoại không được để trống",
        },
        "city": {
            required: "Địa chỉ không được để trống",
        },
        
    },
    errorPlacement: function(error, element) {
        $(element).parent('div').children('.err').html(error);
    },
    // submitHandler: function() {
    //     var name =  $('[name=name').val();
    //     var phone =  $('[name=phone').val();
    //     var email =  $('[name=email').val();
    //     var city =  $('[name=city').val();
    //     var note =  $('[name=note').val();
    //     $.ajax({
    //         url: "/web_demo/Ajax/checkout.php",
    //         type: 'get',
    //         dataType: "json",
    //         data: {
    //             name: name,
    //             phone: phone,
    //             email: email,
    //             city: city,
    //             note:note,
    //         },
    //         success: function(result) {
    //            if(result == true){
    //             $('.popup__all').toggleClass('hidden');
    //            }
    //         },
            
    //     });
    // }
});