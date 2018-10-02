$(function () {

    $('.btnTokenEmpresa').click(function () {

        //Assim é possível acessar o $(this) dentro do ajax
        var btn = $(this);

        /**
         * Verifica se os campos estão vazios
         */
        if ($('#areaChave').is(':visible')) {
            if ($('#cargo').val() == '') {
                $('.mensagem_all_content').text('Favor preencher o campo Cargo');
                $('.mensagem_all_content').removeClass('error');
                $('.mensagem_all').fadeIn();
                return;
            }
            if ($('#salario').val() == '') {
                $('.mensagem_all_content').text('Favor preencher o campo Salário');
                $('.mensagem_all_content').removeClass('error');
                $('.mensagem_all').fadeIn();
                return;
            }
            if ($('#chave').val() == '') {
                $('.mensagem_all_content').text('Entre com a chave para contratar');
                $('.mensagem_all_content').removeClass('error');
                $('.mensagem_all').fadeIn();
                return;
            }
        }


        //Passa os paramentros da forma correta
        var params = {
            id: btn.val(),
            chave: $('#chave').val(),
            cargo: $('#cargo').val(),
            salario: $('#salario').val(),
            idfuncionario: $('#idfuncionario').val(),
            idempresa: $('#idempresa').val()
        };
        var ser_data = jQuery.param(params);

        $.ajax({
            type: 'post',
            url: '',
            async: false,
            data: ser_data,
            beforeSend: function () {
                $('.carregando').fadeIn();
            },
            success: function (data) {
                if (data.success === 'ok') {
                    if (data.enviado == null) {

                        //Pega o token encriptado e seta ele no campo oculto
                        $('#tokenEncrypt').val(data.tokenEncrypt);

                        //Mostra a mensagem para o usuário
                        $('.mensagem_all_content').text(data.message);
                        $('.mensagem_all_content').removeClass('error');

                        //Altera o texto do botão
                        $('.btnToken').hide();
                        btn.show();
                        btn.html('Confirmar');

                    } else {
                        alert(data.alert);
                        location.reload();
                    }
                } else {
                    //Mostra a mensagem para o usuário
                    $('.mensagem_all_content').text('Erro ao tentar enviar os dados: \n' + data.message);
                    $('.mensagem_all_content').addClass('error');
                }
            },
            complete: function () {

                //Para o loading
                $('.carregando').fadeOut();

                //Mostra a mensagem para o usuário
                $('.mensagem_all').fadeIn();

                //Copia chave encriptada
                $('#tokenEncrypt').select();
                document.execCommand('copy');

                //Mostra o campo para a entrada do token
                $('#areaChave').show();
            }
        });
    });
});