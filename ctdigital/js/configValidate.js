$(function () {

    /**
     * Valida qualquer formulario
     */
    $('form').validate();

    /**
     * Campo obrigatorio
     */
    $(".fldObrigatorio").each(function () {
        $(this).rules("add", {
            required: true,
            minlength: 3,
            messages: {
                required: "Campo obrigatorio",
                minlength: "Favor terminar de preencher o campo"
            }
        });
    });

});