var count = 1;

var copyFirstTemplate = function () {
    var value = $(this).val();
    ///no permito nuevos opciones si existe al menos un input vacio
    var countEmptyOptions2 = countEmptyOptions();
    
    ///Verifico si el indice ya se esta usando. (no verifico cuando selecciono el 0, para borrar)
    if (countUsedIndex(value) > 1 && value !== '0') {
        alert('El tipo documental ya se encuentra en uso');
        $(this).val($(this).data('previous_val'));
        return false;
    }

    ///Si selecciono vacio un select y ya existe alguno vacio, entonces elimino este
    if (countEmptyOptions2 > 0) {
        if (value === '0')
            deleteIndice($(this));
        return false;
    }

    ///si el no es un indice vacio, creo un nuevo select
    if (value !== '0') {
        ///Colono el primer select
        var tpl = $('#fs_tiposdocumetales > div:last').clone(true);
        ///Modifico los valores (id, name) del select y el checkbox
        tpl.find('select')
                .attr('id', 'Tiposdocstipopaquete' + count + 'tiposdocumentale_id')
                .attr('name', 'data[Tiposdocstipopaquete][' + count + '][tiposdocumentale_id]');
        tpl.find('input')
                .attr('id', 'Tiposdocstipopaquete' + count + 'Obligatorio')
                .attr('name', 'data[Tiposdocstipopaquete][' + count + '][obligatorio]');
        tpl.appendTo("#fs_tiposdocumetales");
        ///incremento el contador para no tener repetidos
        count++;
    }
};

///Recorre los select de indicces para contar si el valor ya fue seleccionado
var countUsedIndex = function (value) {
    var result = 0;
    $('#fs_tiposdocumetales select').each(function () {
        if ($(this).val() === value)
            result++;
    });
    console.log('countUsedIndex', result);
    return result;
};

/**
 * 
 * @param {jquery} select select que disparó el evento
 * @returns void
 * Oculta el div si es un div que viene de la BD para que el controlador lo borre
 * Elimina el div si es un div creado dinamicamente (temporal)
 * Reviso si el select tiene un inpun hidden hermano (id que viene de la BD).
 */
var deleteIndice = function (select) {
    ///El checkbo tienen un input hidden fantasma.
    if (select.parent().find('input[type=hidden]').length > 1)
        select.parents('.control-group').hide();
    else
        select.parents('.control-group').remove();
}

///Recorre los inputs de las opciones para ver si hay almenos uno vacio
var countEmptyOptions = function () {
    var result = 0;
    $('#fs_tiposdocumetales select').each(function () {
        if ($(this).val() === '0') {
            result++;
        }
    });
    return result;
};

$(document).ready(function () {
    $('.select_tipodocumental').focus(function () {
        $(this).data('previous_val', $(this).val())
    }).change(copyFirstTemplate);

    count = $('#fs_tiposdocumetales > div').length;
});