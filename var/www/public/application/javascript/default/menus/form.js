$(document).ready(function() {
    $('.ui.form').form({
        menu_name: {
            identifier: 'menu_name',
            rules: [
                {
                    type : 'empty',
                    prompt : 'O nome do menu deve ser preenchido'
                }
            ]
        }
    }, {
        inline: true,
        transition: 'fade',
        duration: 300
    });
});