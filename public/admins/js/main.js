$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#category_id').select2({
    placeholder: "Chọn danh mục",
    width: "100%",
});
$('#size_id').select2({
    placeholder: "Chọn size sản phẩm",
    multiple: true,
    width: "100%",
   
});
$('#color_id').select2({
    placeholder: "Chọn màu sản phẩm",
    multiple: true,
    width: "100%",
});

$('#sub_category_id').select2({
    placeholder: "Chọn loại danh mục",
    width: "100%",
});

function loadFile(event, img_sub) {
    var html='';
    var files = $(img_sub)[0].files;
    var num_img = 5 - $('.img_show').length;
    if (num_img>=1) {
        if (files.length <= 0) {
            alert('Bạn chưa chọn tệp upload');
        } else {
            for (var i = 0; i < files.length; i++) {
                var name = document.getElementById('img_sub').files[i].name;
                var ext = name.split('.').pop().toLowerCase();
                if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'jfif']) == -1) {
                    alert('Bạn chỉ được upload file ảnh');
                }else{
                var f = document.getElementById('img_sub').files[i];
                var fsize = f.size || f.fileSize;
                if (fsize > 2097152) {
                    alert('Bạn chỉ được upload file dưới 2MB');

                } else {
                    var src = URL.createObjectURL(event.target.files[i]);
                    html +='<a class="img_show"><img src="' + src + '" ><i class="fas fa-trash delete_imgshow" onclick="Remove_ImgShow(this)"></i></a>';
                 
                }
            }
            }
        }
    }else{
        alert('Bạn chỉ được upload tối đa 4 ảnh');
    }
    $('.img_prew_sub').html(html);
}
function loadFile1(event, img) {
    var html='';
    var files = $(img)[0].files[0];
    var name = document.getElementById('img').files[0].name;
    var ext = name.split('.').pop().toLowerCase();
        if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'jfif']) == -1) {
            alert('Bạn chỉ được upload file ảnh');
        }else{
        var f = document.getElementById('img').files[0];
        var fsize = f.size || f.fileSize;
        if (fsize > 2097152) {
            alert('Bạn chỉ được upload file dưới 2MB');

        } else {
            var src = URL.createObjectURL(event.target.files[0]);
            html +='<a class="img_show"><img src="' + src + '" ><i class="fas fa-trash delete_imgshow" onclick="Remove_ImgShow(this)"></i></a>';
            
        }
    }  
    $('.img_prew').html(html);
}
function Remove_ImgShow(e){
    $(e).parents('.img_show').addClass('tick');
    var arr_img = new Array();
    $('.img_show').each(function() {
        if ($(this).hasClass('tick')) {
            arr_img.push(1);
        } else {
            arr_img.push(0);
        }
    });
   var index = arr_img.indexOf(1)
//    console.log(index);
    $(e).parents('.img_show').remove();
    // var files = $('#upload_img')[0].files;
   
    // var $a = document.getElementById('upload_img').files[index];
    
    // console.log($a);

}
function getSubCategori(category, sub_category) {
    $.ajax({
        url: "/admin/products/get_sub_category",
        type: 'post',
        dataType: "json",
        data: {
            id: $(category).val(),
        },
        success: function(result) {
            if (result.categories.length > 0) {
                var i = 0;
                var html = "<option value=''>Chọn danh mục</option>";
                for (i = 0; i < result.categories.length; i++) {
                        html += `<option value="` + result.categories[i].id  + `">` + result.categories[i].name + `</option>`;
                }
                $(sub_category).html(html);
                $(sub_category).trigger("change");
            } else {
                $(sub_category).html('');
            }
        },
      
    });
}



$('#category_id').change(function() {
    getSubCategori(this, "#sub_category_id");
});