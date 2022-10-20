$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#role').select2({
    placeholder: "Chọn chức vụ",
    width: "100%",
})
$('#email_verified_at').select2({
    placeholder: "Chọn kích hoạt",
    width: "100%",
})