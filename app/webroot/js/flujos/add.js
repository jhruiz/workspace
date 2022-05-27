var countIndices = 1;

var copyFirstIndiceTemplate = function () {
    var value = $(this).val();
    ///no permito nuevos opciones si existe al menos un input vacio
    var count = countEmptyOptions();
    
    ///Verifico si el indice ya se esta usando. (no verifico cuando selecciono el 0, para borrar)
    if(countUsedIndex(value) > 1  && value !== '0'){
        alert('El índice ya se encuentra en uso');
        $(this).val($(this).data('previous_val'));
        return false;
    }

    ///Si selecciono vacio un select y ya existe alguno vacio, entonces elimino este
    if (count > 0) {
        if (value === '0')
            $(this).parents('.control-group').remove();
        return false;
    }    

    ///si el no es un indice vacio, creo un nuevo select
    if (value !== '0') {

        ///Colono el primer select
        var tpl = $('#fs_indices div:first').clone(true);
        ///Modifico los valores (id, name) del select y el checkbox
        tpl.find('select')
                .attr('id', 'Flujosdatoscabecera' + countIndices + 'IndicedocId')
                .attr('name', 'data[Flujosdatoscabecera][' + countIndices + '][indicedoc_id]');
        tpl.find('input')
                .attr('id', 'Flujosdatoscabecera' + countIndices + 'Obligatorio')
                .attr('name', 'data[Flujosdatoscabecera][' + countIndices + '][obligatorio]');
        tpl.appendTo("#fs_indices");
        ///incremento el contador para no tener repetidos
        countIndices++;
    }
};

///Recorre los select de indicces para contar si el valor ya fue seleccionado
var countUsedIndex = function (value) {
    var result = 0;
    $('#fs_indices select').each(function () {
        if ($(this).val() === value) 
            result++;        
    });
    console.log('countUsedIndex', result);
    return result;
};

///Recorre los inputs de las opciones para ver si hay almenos uno vacio
var countEmptyOptions = function () {
    var result = 0;
    $('#fs_indices select').each(function () {
//        con   sole.log();
        if ($(this).val() === '0') {
            result++;
        }
    });
    return result;
};

$(document).ready(function () {
    $('.select_indice').focus(function () {
        $(this).data('previous_val', $(this).val())
    }).change(copyFirstIndiceTemplate);
});

