
$(document).ready(function() {
    $('body').transition('fade');
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

    $('.ui.sidebar').sidebar({
        useCSS: true,
        debug: false
    });

    $('.ui.dropdown').dropdown({
        debug: false
    });

    $('[data-toggle="filter"]').click(function() {
        var target, placement;

        target = $(this).attr('data-target') || $(this).attr('href');
        placement = $(this).attr('data-placement') || 'slide up';

        $(target).transition(placement);
    });

    $('.haspopup').popup({
        debug: false
    });

    $('[data-submit]').click(function(e) {
        e.preventDefault();
        var form;

        form = $(this);

        while(!form.is('form')) {
            form = form.parent();
        }

        form.submit();
    });

});