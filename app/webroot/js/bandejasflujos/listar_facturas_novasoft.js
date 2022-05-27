var fnClickExcel = function () {
    var parent = $(this).parent().parent();
    var checkCargadoHermano = parent.find('input.cargado');
    var hiddenInlcuidoExcel = parent.find('input.incluido_excel');

    if ($(this).is(":checked")) {

        if (hiddenInlcuidoExcel.val() == 'S') {
            checkCargadoHermano.attr('disabled', false);
        } else {
            checkCargadoHermano.attr('disabled', true);
        }

    } else {
        checkCargadoHermano.attr('checked', false);
        checkCargadoHermano.attr('disabled', true);
    }
};

var fnEnviarServer = function (data) {
    $.post($('#url-proyecto').val() + 'bandejasflujos/ajaxSetDatosInfoPaquetes', {data: data}, function (data) {
        
        location.reload();
    }, 'json');
};

var fnGuardar = function () {

    bootbox.confirm("¿Desea guardar la informacion ingresada?", function (result) {
        if (result) {
            var data = [];
            $('input.excel').each(function () {
                var parent = $(this).parent().parent();
                var obj = {
                    id: parent.data('infopaqueteid'),
                    paquete_id: parent.data('paqueteid'),
                    incluido_excel_novasoft: $(this).is(":checked"),
                    cargado_novasoft_exito: parent.find('input.cargado').first().is(":checked"),
                    flujotesoreria_id: parent.find('#selflujotesoreria').first().val(),
                    banco_id: parent.find('#selbanco').first().val(),
                    txtcscnovasoft: parent.find('#txtcscnovasoft').first().val()
                    
                };
                data.push(obj);
            });

            fnEnviarServer(data);
        }
    });


};

var fnGenerarExcel = function () {

//    var result = confirm("¿Desea generar el archivo para Novasoft?");
    bootbox.confirm("¿Desea generar el archivo para Novasoft?", function (result) {
        if (result) {

            var data = "";
            var primero = true;
            $('input.excel').each(function () {
                var parent = $(this).parent().parent();

                if ($(this).is(":checked")) {
                    var sep = "|";
                    if (primero) {
                        sep = "";
                        primero = false;
                    }
                    data += "" + sep + "" + parent.data('paqueteid');
                }
            });

            if (data.length == 0) {
                bootbox.alert("No ha seleccionado facturas. Seleccione e intente nuevamente.");
            } else {
                var href = $('#url-proyecto').val() + 'bandejasflujos/generarPlanoNovasoft/';
                href = "" + href + "" + data;
                $.fileDownload(href, {
                    successCallback: function (url) {
                        bootbox.alert("Generación exitosa!", function () {
                            location.reload();
                        });
                    },
                    failCallback: function (html, url) {
                        bootbox.alert('La descarga ha fallado para la URL:' + url + '<br>' + html);
                    }
                });
            }
        }
    });

    return false;
};

var fnSeleccionarTodosExcel = function () {
    if ($(this).data('seleccionar') == '1') {
        $('.excel').prop('checked', true);
        $('.cargado').attr('disabled', false);
        $(this).data('seleccionar', '0');
    } else {
        $('.excel').prop('checked', false);
        $('.cargado').prop('checked', false);
        $('.cargado').attr('disabled', true);
        $(this).data('seleccionar', '1');
    }
};

var fnSeleccionarTodosCargado = function () {
    if ($(this).data('seleccionar') == '1') {
        $('.cargado:enabled').prop('checked', true);
        $(this).data('seleccionar', '0');
    } else {
        $('.cargado:enabled').prop('checked', false);
        $(this).data('seleccionar', '1');
    }
};

function seleccionarPredeterminados() {
    $('input.excel').each(function () {
        var parent = $(this).parent();
        var hiddenInlcuidoExcel = parent.find('input.incluido_excel');

        if (hiddenInlcuidoExcel.val() == 'S') {
            $(this).prop("checked", false);
            $(this).click();
        }

    });
}


$(function () {
    $('.excel').click(fnClickExcel);
    $('#btn_guardar').click(fnGuardar);
    $('#btn_generar').click(fnGenerarExcel);

    $('#select_all_excel').click(fnSeleccionarTodosExcel);
    $('#select_all_cargado').click(fnSeleccionarTodosCargado);

    seleccionarPredeterminados();

});