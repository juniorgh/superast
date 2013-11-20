
$(document).ready(function() {
    /** 
     * Alterna a visualização das sidebar's
     */
    $('[data-toggle="sidebar"]').click(function(e) {
        e.preventDefault();
        var target = $(this).attr('href') || $(this).attr('data-target');
        $(target).sidebar('toggle');

        if($(this).hasClass('active')) {
            $(this).removeClass('active');
        } else {
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
        }
    });

    $('.ui.sidebar').sidebar({
        useCSS: true,
        debug: false
    });

    $('.ui.dropdown').dropdown();
});