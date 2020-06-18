$(document).ready(function () {
    // Navbar
    $('.rotary-navbar .dmenu').hover(function () {
        $(this).find('.sm-menu').first().stop(true, true).slideDown(150);
    }, function () {
        $(this).find('.sm-menu').first().stop(true, true).slideUp(105);
    });

    // Carousel
    $('.accueil-carousel').owlCarousel({
        loop:true,
        margin: 10,
        dots: false,
        nav: true,
        mouseDrag: false,
        autoplay: true,
        animateOut: 'slideOutUp',
        responsive: {
            0:{ items:1},
            600:{ items: 1},
            1000: {items:1}
        }
    });


})