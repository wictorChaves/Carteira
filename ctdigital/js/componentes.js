$(function () {
    $(".municipio").autocomplete({
        source: function (request, response) {
            console.log(request);
            var params = {
                QueryFilter: request.term
            };
            var ser_data = jQuery.param(params);
            $.ajax({
                dataType: "json",
                type: 'POST',
                url: '?municipio=true',
                data: ser_data,
                success: function (data) {
                    response($.map(data, function (item) {
                        return {
                            id: item.id,
                            label: item.valor,
                            value: item.valor
                        };
                    }));
                },
                error: function (data) {
                    console.log(data);
                }
            });
        },
        minLength: 3,
        open: function () {},
        close: function () {},
        focus: function (event, ui) {},
        select: function (event, ui) {
            var id = '#' + $(this).attr('id').replace("_cp_", "");
            $(id).val(ui.item.id);
        }
    });
    $('#internacional').hide();
    $('#nacionalidade').change(function () {
        //Use $option (with the "$") to see that the variable is a jQuery object
        var $option = $(this).find('option:selected');
        //Added with the EDIT
        var value = $option.val();//to get content of "value" attrib
        var text = $option.text();//to get <option>Text</option> content
        console.log(value);
        console.log(text);
        if (value == 7) {
            console.log('ok');
            $('#internacional').fadeOut();
            $('#nascional').fadeIn();
        } else {
            console.log('not');
            $('#internacional').fadeIn();
            $('#nascional').fadeOut();
        }
    });
});