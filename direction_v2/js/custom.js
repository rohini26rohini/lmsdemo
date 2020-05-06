$(function () {
    $(".demo").bootstrapNews({
        newsPerPage: 3,
        navigation: true,
        autoplay: true,
        direction: 'up', // up or down
        animationSpeed: 'normal',
        newsTickerInterval: 4000, //4 secs
        pauseOnHover: true,
        onStop: null,
        onPause: null,
        onReset: null,
        onPrev: null,
        onNext: null,
        onToDo: null
    });

    $(".news_tick").bootstrapNews({
        newsPerPage: 2,
        navigation: true,
        autoplay: true,
        pauseOnHover: true,
        direction: 'up',
        newsTickerInterval: 4000,

    });
});

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();   
    $(".ham_nav").click(function () {
        $(".mobile_nav").fadeIn();
        $(this).fadeOut();
        $(".nav_close").fadeIn();
    });
    $(".nav_close").click(function () {
        $(".mobile_nav").fadeOut();
        $(this).fadeOut();
        $(".ham_nav").fadeIn();
    });





    $(".mobile_nav_scroll ul li a ").click(function () {
        $(this).find(".root_arw").toggleClass("transform");
    });
    $(".mobile_nav_scroll ul li").mouseleave(function () {
        $(this).find(".collapse").slideUp().removeClass("in");
    });

    $('#team').owlCarousel({
        loop: true,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        responsiveClass: true,
        nav: false,
        dots: false,
        responsive: {
            0: {
                items: 1,

            },
            601: {
                items: 2,

            },
            981: {
                items: 3,

            },
            1367: {
                items: 4,


                margin: 20
            }
        }
    });
    $('.carousel').carousel({
        interval: 5000
    })
    $('#announcement').owlCarousel({
        loop: true,
        autoplay: true,
        margin: 10,
        //                dots: false,
        autoplayTimeout: 16000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            641: {
                items: 2,
                nav: false
            },
            1025: {
                items: 3,
                nav: true,
                loop: true,
                margin: 20
            }
        }
    });
    $('#features_owl').owlCarousel({
        loop: true,
        margin: 10,
        autoplay: true,
        speed: 400,
        verticalHeight: 600,
        autoplayHoverPause: true,
        responsiveClass: true,

        responsive: {
            0: {
                items: 2,
                nav: true
            },
            801: {
                items: 3,
                nav: false
            },
            1025: {
                items: 4,
                nav: true,
                loop: false,
                margin: 20
            }
        }
    });

    $('#month').owlCarousel({
        loop: true,
        margin: 10,
        //                autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            600: {
                items: 2,
                nav: true
            },
            1366: {
                items: 3,
                nav: true,
                loop: true,
                margin: 20
            }
        }
    });

    $('#subject').owlCarousel({
        loop: true,
        margin: 10,
        dots: true,
        //                autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            600: {
                items: 2,
                nav: true
            },
            1366: {
                items: 3,
                nav: true,
                loop: true,
                margin: 20
            }
        }
    });
    //
    //
    $('#tutorials').owlCarousel({
        loop: true,
        margin: 10,
        dots: false,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            600: {
                items: 3,
                nav: false
            },
            1000: {
                items: 3,
                nav: true,
                loop: true,
                margin: 20
            }
        }
    });
    //


    $('#program_owl').owlCarousel({
        //        loop: true,
        dots: true,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            601: {
                items: 2,
                nav: true
            },
            801: {
                items: 3,
                nav: true
            },
            1200: {
                items: 2,
                nav: true,

                margin: 20
            }
        }
    });


});
$(window).scroll(function () {
    if ($(this).scrollTop() > 1) {
        $('header').addClass("sticky ");


    } else {
        $('header').removeClass("sticky ");

    }
});
