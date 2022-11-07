var nuevoDocumento = function(){
    window.location.href = $('#url-proyecto').val() + "documentos/add";
};

var eliminarDocumento = function(){
    bootbox.confirm("¿Está seguro que desea eliminar el documento?", function(result){ 
        if(result) {
            documpaq_id = $('#selDocPaq').val();

            $.ajax({
                type: 'POST',
                async: false,
                url: $('#url-proyecto').val()+'documentos_paquetes/desactivardocpaqueteajax',
                data: {documpaq_id: documpaq_id},
                success: function(data){ 
                    var respuesta = JSON.parse(data); 
                    if(respuesta.estado){
                        bootbox.alert("Documento eliminado exitosamente", function(){ 
                            location.reload(true); 
                        });
                    }else{
                        bootbox.alert("No fue posible eliminar el documento. Por favor, inténtelo nuevamente.");
                    }
                }
            });
        }
    });
}


