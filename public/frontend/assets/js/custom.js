window.addEventListener('scroll', function(){
    const header = document.getElementById('stickyHeader');
    header.classList.toggle('sticky', window.scrollY > 0);
});

// current year
var d = new Date();
const currentYear = document.getElementById('currentYear');
currentYear.outerHTML = d.getFullYear();

(function ($) {
    "use-strict"

    jQuery(document).ready(function () {

        if ($('#welcome_slider').length > 0) {
            $('#welcome_slider').owlCarousel({
                items: 1,
                loop: true,
                autoplay: true,
                autoplayTimeout: 3000,
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
                smartSpeed:450,
                touchDrag  : true,
                mouseDrag  : false,
                nav: false,
                dots: false
            });
        }

        //resort->details->room carousel
        if ($('.room-image-carousel').length > 0) {
            $('.room-image-carousel').owlCarousel({
                items: 1,
                loop: true,
                autoplay: true,
                autoplayTimeout: 3000,
                smartSpeed:450,
                nav: true,
                navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
                dots: false
            });
        }

        if ($('#resortCarousel').length > 0) {

            $('#resortCarousel').owlCarousel({
                items: 4,
                margin: 15,
                loop: true,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplaySpeed: 1000,
                navSpeed: 1000,
                nav: false,
                navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
                dots: false,
                autoplayHoverPause: true,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1
                    },
                    480: {
                        items: 2
                    },
                    768: {
                        items: 3
                    },
                    992:{
                        items:4
                    },
                    1600: {
                        items: 4
                    }
                }
            });
        }

        if ($('.destinations').length > 0) {
            $('.destinations').owlCarousel({
                items: 4,
                loop: true,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplaySpeed: 1000,
                nav: false,
                dots: false,
                margin: 20,
                autoplayHoverPause: true,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1
                    },
                    480: {
                        items: 2
                    },
                    768:{
                        items:3
                    },
                    992:{
                        items:4
                    }
                }
            });
        }

        if ($('.package-items').length > 0) {
            $('.package-items').owlCarousel({
                items: 1,
                loop: true,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplaySpeed: 2000,
                nav: false,
                dots: true,
                autoplayHoverPause: true,
            });
        }

        if ($('.testimonials').length > 0) {
            $('.testimonials').owlCarousel({
                items: 2,
                loop: true,
                margin: 30,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplaySpeed: 1000,
                nav: true,
                navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
                dots: false,
                autoplayHoverPause: true,
            });
        }

        $('.parallax-section').parallax();


        if($('.events').length){
            $('.events').slick({
                slidesToShow: 3,
                dots: true,
                autoplay: true,
                centerMode: true,
                arrows: false,
                vertical:true,
                centerPadding: "0px",
                responsive: [
                {
                  breakpoint: 992,
                  settings: {
                      arrows: false,
                      slidesToShow: 3
                  }
                },
                {
                  breakpoint: 768,
                  settings: {
                      arrows: false,
                      slidesToShow: 3
                  }
                },
                {
                  breakpoint: 670,
                  settings: {
                      arrows: false,
                      centerMode: false,
                      slidesToShow: 1
                  }
                }]
            });
          }

        $(document).on('click', '.responsive-menu-bar', function() {
            $('.responsive-menu').toggleClass('show-responsive-menu');
        });

        $(document).on('click', '#close_menu', function(e) {
            $('.responsive-menu').removeClass('show-responsive-menu');
        });



    });

}(jQuery));

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: false,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
