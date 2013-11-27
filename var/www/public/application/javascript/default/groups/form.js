$(document).ready(function() {
    $('#checkall').click(function() {
        $('.menu_checkbox').checkbox('enable');
    });

    $('#uncheckall').click(function() {
        $('.menu_checkbox').checkbox('disable');
    });
});