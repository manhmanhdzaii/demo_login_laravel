$('.slider_banner').owlCarousel({
    loop:true,
    margin:0,
    nav:true,
    dots: true,
    autoplay: true,
    autoplayTimeout: 4000,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        },
        1300:{
            items: 1
        }
    }
})