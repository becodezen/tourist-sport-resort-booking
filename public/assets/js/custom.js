(function ($) {
    "use-strict"

    jQuery(document).ready(function () {

        $('[data-toggle="tooltip"]').tooltip();

        //active navigation class
        var current = location.href;
        $('nav ul li a').each(function () {
            var $this = $(this);
            if (current === '/' || current === '/admin' || current === '/admin/') {
                $('.index-link').closest('li').addClass('active');
                return false;
            }else if ($this.attr('href') === current) {
                $this.closest('.treeview').addClass('nav-open menu-open');
                $this.closest('.treeview-menu').show();
                $this.closest('li').addClass('active');
            }
        });

        $(document).on('click', '.nav-bar', function() {
            $('.page-content-area').toggleClass('no-sidebar');
            $('.header-logo').toggleClass('no-header-logo');
        });

        //vb-modal
        $(document).on('click', '.vb-modal', function () {
            $('.vb-modal-wrap').addClass('open-vb-modal');
        });

        $(document).on('click', '.vb-modal-wrap', function (event) {
            if (this === event.target) {
                $('.vb-modal-wrap').removeClass('open-vb-modal');
            }
        });

        $(window).resize(function () {
            if (window.matchMedia('(max-width: 768px)').matches) {
                $('.page-content-area').addClass('no-sidebar');
                $('.header-logo').addClass('no-header-logo');
                $('.search_form').css({
                    width: '300px'
                });
            } else {
                $('.page-content-area').removeClass('no-sidebar');
                $('.header-logo').removeClass('no-header-logo');
                $('.search_form').css({
                    width: '390px'
                });
            }
        });

    });

    jQuery(window).on('load', function () {

        if (window.matchMedia('(max-width: 768px)').matches) {
            $('.page-content-area').addClass('no-sidebar');
            $('.header-logo').addClass('no-header-logo');
            $('.search_form').css({
                width: '300px'
            });
        } else {
            $('.page-content-area').removeClass('no-sidebar');
            $('.header-logo').removeClass('no-header-logo');
            $('.search_form').css({
                width: '390px'
            });
        }
    });

}(jQuery));
