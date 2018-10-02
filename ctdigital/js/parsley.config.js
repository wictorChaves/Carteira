window.Parsley.addValidator('idade', {
    validateString: function (value, requirement) {
        var valor = value.split("/");

        var rightNow = new Date();
        var dataAtual = rightNow.toISOString().slice(0, 10).split("-");

        valor = new Date(valor[1] + "/" + valor[0] + "/" + valor[2]).getTime();
        dataAtual = new Date(dataAtual[1] + "/" + dataAtual[2] + "/" + dataAtual[0]).getTime();

        if ((dataAtual - valor) > (31536000000 * requirement)) {
            return true;
        }
        return false;
    },
    messages: {
        en: 'A data deve ser válida e a idade maior que %s.',
        fr: "A data deve ser válida e a idade maior que %s."
    }
});

