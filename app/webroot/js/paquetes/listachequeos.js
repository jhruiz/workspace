/**
 * Agrega el registro del checkeo
 * @param {*} infoItem 
 */
function agregarItemBandeja(infoItem){
    var paqueteId = $('#paqueteId').val();
    $.post($('#url-proyecto').val()+'bandejas_listachequeos_usuarios/agregaritembandejausuario',{
        bandeja: infoItem['0'],
        item: infoItem['1'],
        paqueteId: paqueteId
    },function(responseText){
        var respuesta = JSON.parse(responseText);
        if(respuesta.resp){
            $('#userDate_' + infoItem['1']).html(respuesta.username + '(' + respuesta.date + ')');
        }
    });      
}

/**
 * Elimina el registro del checkeo
 * @param {*} infoItem 
 */
function eliminarItemBandeja(infoItem){
    var paqueteId = $('#paqueteId').val();
    $.post($('#url-proyecto').val()+'bandejas_listachequeos_usuarios/eliminaritembandejausuario',{
        bandeja: infoItem['0'],
        item: infoItem['1'],
        paqueteId: paqueteId
    },function(responseText){
        var respuesta = JSON.parse(responseText);
        if(respuesta.resp) {
            $('#userDate_' + infoItem['1']).html('');
        }
    });  
}

/**
 * Valida si el checkbox fue seleccionado o deseleccionado
 * @param {*} data 
 */
function checkListBandeja(data){

    var infoItem = data.id.split('_');
    if( $('#' + data.id).prop('checked') ) {
        this.agregarItemBandeja(infoItem);
    } else {
        this.eliminarItemBandeja(infoItem);
    }

};
