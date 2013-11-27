$(document).ready(function() {
    $('body').transition('fade');
    setTimeout(function() {
        /** 
         * Alterna a visualização das sidebar's
         */
        $('[data-toggle="sidebar"]').click(function(e) {
            e.preventDefault();
            var target = $(this).attr('href') || $(this).attr('data-target');
            
            $(target).sidebar('toggle');

            if($(this).hasClass('active')) {
                $(this).removeClass('active');
                $('.page-active').addClass('active');
            } else {
                $(this).siblings().removeClass('active');
                $(this).addClass('active');
            }
        });
    }, 1000);

    $('[data-toggle="filter"]').click(function() {
        var target, placement;

        target = $(this).attr('data-target') || $(this).attr('href');
        placement = $(this).attr('data-placement') || 'slide up';

        $(target).transition(placement);
    });

    $('.drop.entry').click(function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        $('#modal_drop_entry').modal('setting', {
            onApprove: function() {
                window.location.href = href;
            }
        }).modal('show');
    });

    $('.ui.sidebar').sidebar({
        debug: false
    });

    $('.ui.dropdown').dropdown({
        debug: false
    });

    $('.haspopup').popup({
        debug: false
    });

    $('.ui.form').form({
        debug: false
    });

    $('.ui.checkbox').checkbox({
        debug: false
    });

    // $('.ui.sidebar').sidebar('setting', 'onShow', function() {}); /* incluindo callbacks para a sidebar */
});