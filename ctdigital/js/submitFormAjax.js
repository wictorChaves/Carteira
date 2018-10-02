$(function () {

    //Pega o formulario da pagina
    var formulario = null;
    if (Array.isArray($('form'))) {
        var formulario = "#" + $('form')[0].attr('id');
    } else {
        var formulario = "#" + $('form').attr('id');
    }

    var asyncconf = true;

    if ($(formulario).attr('name') == 'ajaxoff') {
        return false;
    }

    if ($(formulario).attr('name') == 'asyncoff') {
        asyncconf = false;
    }

    $(formulario).submit(function (event) {
        event.preventDefault();
        var form = $(this);
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            async: asyncconf,
            data: form.serialize(),
            beforeSend: function () {
                $('.carregando').fadeIn();
            },
            success: function (data) {
                console.log(data);
                if (data.redirecionar != null) {
                    $(location).attr('href', data.redirecionar)
                }
                if (data.setasync != null) {
                    asyncconf = (data.setasync == 'true');
                }
                if (data.mudanome != null) {
                    $.each(data.mudanome, function (index, value) {
                        var idcampo = '#' + value[0];
                        $(idcampo).val(value[1]);
                    });
                }
                if (data.settexto != null) {
                    $.each(data.settexto, function (index, value) {
                        var idcampo = '#' + value[0];
                        $(idcampo).text(value[1]);
                    });
                }
                if (data.mostracmp != null) {
                    $.each(data.mostracmp, function (index, value) {
                        var idcampo = '#' + value;
                        $(idcampo).fadeIn();
                    });
                }
                if (data.ocultacmp != null) {
                    $.each(data.ocultacmp, function (index, value) {
                        var idcampo = '#' + value;
                        $(idcampo).fadeOut();
                    });
                }
                if (data.success != null) {
                    $('.mensagem_all_content').text(data.success);
                    $('.mensagem_all_content').removeClass('error');
                    $('.mensagem_all').fadeIn();
                }
                if (data.fail != null) {
                    $('.mensagem_all_content').text(data.fail);
                    $('.mensagem_all_content').addClass('error');
                    $('.mensagem_all').fadeIn();
                }
                if (data.alert != null) {
                    alert(data.alert);
                }
                if (data.limpacmp != null) {
                    $('textarea').val('');
                    $(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
                    $(':checkbox, :radio').prop('checked', false);
                }
            },
            complete: function () {
                $('.carregando').fadeOut();
                if ($('#transfer').val() != '') {
                    $('#transfer').select();
                    document.execCommand('copy');
                }
            }
        });
        return false;
    });
});