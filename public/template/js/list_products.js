const rangeInput = document.querySelectorAll(".range_input input"),
priceInput = document.querySelectorAll(".pricer_input input"),
progress = document.querySelector(".slider .progress");
let pricegap = 100;
priceInput.forEach(input => {
    input.addEventListener("input", e=>{
        let minval = parseInt(priceInput[0].value), 
        maxval = parseInt(priceInput[1].value);
        if((maxval - minval >= pricegap) && maxval <= 1000){
            if(e.target.className === "ip_min"){
                rangeInput[0].value = minval;
                progress.style.left = (minval / rangeInput[0].max)*100 + "%";
            }else{
                rangeInput[1].value = maxval;
                progress.style.right = 100 - (maxval / rangeInput[1].max)*100 + "%";
            }
           
        }
       
    })
})
rangeInput.forEach(input => {
    input.addEventListener("input", e=>{
        let minval = parseInt(rangeInput[0].value), 
        maxval = parseInt(rangeInput[1].value);
        if(maxval - minval < pricegap){
            if(e.target.className === "range_min"){
                rangeInput[0].value = maxval - pricegap;
            }else{
                rangeInput[1].value = minval + pricegap;
            }  
        }else{
            priceInput[0].value = minval;
            priceInput[1].value = maxval;
            progress.style.left = (minval / rangeInput[0].max)*100 + "%";
            progress.style.right = 100 - (maxval / rangeInput[1].max)*100 + "%";
        }
       
    })
})

$(".list_sort_check").click(function() {
    $('.list_sort_all').toggleClass('hidden');
})

$('.list_sort_post').click(function() {
    let $title_post = $(this).html();
   let $title = $('.list_sort_check_tittle').html(); 
   if($title_post !== $title ){
    $('.list_sort_check_tittle').html($title_post);
   }
})