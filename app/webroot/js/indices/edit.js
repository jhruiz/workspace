///muestra y esconde el div de opciones segun el valor del select.
var toogleDivOpciones = function() {
    if ($('#IndicedocTipodatoId').val() === '3'){
        $('#div_indice_opciones').show();
        $('.input_opciones').removeAttr('disabled');
    }else{
        $('#div_indice_opciones').hide();
        $('.input_opciones').attr('disabled', 'disabled');
    }
};
///Recorre los inputs de las opciones para ver si hay almenos uno vacio
var validateEmptyOptions = function(){
    var result = true;
    $('.input_opciones').each(function(){
        if(!$(this).val().length){
            result = false;
            return;
        }
    });
    return result;
};
///Borra del DOM el tr seleccionado
var delOption = function(){
    var option_number = $(this).attr('option_number');
    
    ///Si es un reistro en BD
    if($('#Indicesopcione'+option_number+'Id').length){
        $('#tr_option_number_'+option_number).append('<input name="data[Indicesopcione]['+option_number+'][delete]" value="1" type="hidden">');
        $('#tr_option_number_'+option_number).hide();
    }else{
        $('#tr_option_number_'+option_number).remove();
    }
    
    return false;
};
///Va a llevar la cuenta de las opciones.
var countOptions = 1;
///Crea el html de una nueva opcion y la agrega a la tabla
var createHTMLOptionTable = function(){
    ///no permito nuevos opciones si existe al menos un input vacio
    if (!validateEmptyOptions())
        return false;
    
    var template = '<tr  id="tr_option_number_'+countOptions+'"> \
                    <td><input name="data[Indicesopcione]['+countOptions+'][valor]" maxlength="50" id="Indicesopcione'+countOptions+'Valor" type="text" class="input_opciones alfanumeric" required=""></td> \
                    <td><input name="data[Indicesopcione]['+countOptions+'][descripcion]" maxlength="50" id="Indicesopcione'+countOptions+'Descripcion" type="text"  class="input_opciones alfanumeric" required=""></td> \
                    <td><a href="#" option_number="'+countOptions+'" class="a_borrar_opcion">Eliminar</a></td>\
                </tr>';
    $('#div_indice_opciones table').append(template);
    $('.a_borrar_opcion').on('click', delOption);
    countOptions++;
    return false;
};

$(document).ready(function () {
    
    $('#IndicedocTipodatoId').on('change', toogleDivOpciones);
    $('#a_agregar_opcion').on('click', createHTMLOptionTable);
    $('.a_borrar_opcion').on('click', delOption);
    
    countOptions = $('#tbl_indice_opciones tbody tr').length;
    
    toogleDivOpciones();
});
