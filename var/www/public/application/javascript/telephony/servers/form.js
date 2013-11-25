$(document).ready(function() {
    $('.ui.form').form({
        server_hostname: {
            identifier: 'server_hostname',
            rules: [
                {
                    type : 'empty',
                    prompt : 'O hostname da máquina deve ser preenchido'
                }
            ]
        },

        server_ip_address: {
            identifier: 'server_ip_address',
            rules: [
                {
                    type : 'empty',
                    prompt : 'O endereço de IP deve ser preenchido'
                }
            ]
        },

        server_database_user: {
            identifier: 'server_database_user',
            rules: [
                {
                    type : 'empty',
                    prompt : 'O usuário MySQL deve ser preenchido'
                }
            ]
        },

        server_ami_user: {
            identifier: 'server_ami_user',
            rules: [
                {
                    type : 'empty',
                    prompt : 'O usuário do Asterisk Manager deve ser preenchido'
                }
            ]
        },

        server_ami_secret: {
            identifier: 'server_ami_secret',
            rules: [
                {
                    type : 'empty',
                    prompt : 'A senha do usuário do Asterisk Manager deve ser preenchido'
                }
            ]
        }
    }, {
        inline: true,
        transition: 'fade',
        duration: 300
    });
});