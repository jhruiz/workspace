var idUbicacionU = "";
var idPaqueteU = "";


/**
 * Muestra el modal con la ubicación 
 * @param {*} paqueteId 
 * @param {*} idDivTraza 
 */
function mostrarUbicacion(paqueteId, idDivTraza) {

    this.idPaqueteU = paqueteId;

    if (paqueteId > 0) {
        $.post($('#url-proyecto').val() + 'paquetesubicacionesfisicas/mostrarUbicacion',
                {
                    paquete_id: paqueteId
                },
        function (responseText) {
            $('#' + idDivTraza).html(responseText);
            $('#modelUbicacionPq').modal("show");
            $('#modelUbicacionPq').css({'width': '400px', 'left': '50%'});
        });
    }
}

/**
 * Se obtienen los hijos de la opcion seleccionada
 * @param {*} datos 
 */
var obtenerHijos = function(datos) {
    var opt = $(datos).val();
    var idPadre = datos.id;
    this.idUbicacionU = opt;

    if(opt != "") {
        $.ajax({
            type: 'POST',
            dataType:'json',
            async: false,
            url: $('#url-proyecto').val() + "ubicacionesfisicas/obtenersubmenus",
            data: {id_menu: opt},
            success: function(data){   
                var datos=eval(data);  

                //validar si el campo viene vacio para no generar mas hijos
                if(data.length > 0) {
                    generarSelectHijos(datos, idPadre);
                }
            }
        });
    } else {
        $('.opcHijos').html("");
        $('#selectPadre').val("");
    }
}

/**
 * Genera el select hijo
 * @param {*} datos 
 */
var generarSelectHijos = function(datos, idPadre) {
    var nombreId = datos['0'].Ubicacionesfisica.ubicacionesfisica_id + datos['0'].Ubicacionesfisica.id;
    
    var hijosHtml = "";
    hijosHtml += '<select name="' + nombreId + '" id="' + nombreId + '" onchange="obtenerHijos(this);">';
    hijosHtml += '<option value="">Seleccione una..</option>';
    datos.forEach(element => {
        
        hijosHtml += '<option value="' + element.Ubicacionesfisica.id + '">' + element.Ubicacionesfisica.descripcion + '</option>'

    });

    hijosHtml += '</select>';
    hijosHtml += '<div id="' + nombreId + '_hijos" class="opcHijos"></div>';

    $('#' + idPadre + '_hijos').html(hijosHtml);

}

var guardarUbicacion = function() {

    if(idUbicacionU == "") {
        bootbox.alert('Debe seleccionar una ubicación válida.');
    } else {

        $.ajax({
            type: 'POST',
            dataType:'json',
            async: false,
            url: $('#url-proyecto').val() + "paquetesubicacionesfisicas/guardarubicacion",
            data: {idUbicacion: idUbicacionU, idPaquete: idPaqueteU},
            success: function(data){   
                var datos=eval(data); 

                if(datos.resp) {
                    bootbox.alert('Ubicación del paquete de documentos almacenada de forma exitosa.');
                    pintarUbicacionFisica(datos.ubicacion);
                } else {
                    bootbox.alert('No fue posible almacenar la ubicación del paquete.');
                }

                $('#modelUbicacionPq').modal('hide');
            }
        });

    }
}

var pintarUbicacionFisica = function(ubicacion) {

    if(ubicacion.length > 0){
        var htmlUbicacion = "<b>Ubicación: </b>";
        ubicacion.forEach(element => {
            htmlUbicacion += element.Ubicacionesfisica.descripcion + " / ";
        });
    
        $('#trUbicacion').html(htmlUbicacion);
    }

}

/**
 * Obtienen la ubicación física del paquete en gestión
 */
var obtenerUbucacionFisica = function() {

    var idPaquete = $('#paqueteId').val();
    
    $.ajax({
        type: 'POST',
        dataType:'json',
        async: false,
        url: $('#url-proyecto').val() + "paquetesubicacionesfisicas/ubicacionPaquete",
        data: {idPaquete: idPaquete},
        success: function(data){   
            var datos=eval(data);  
            pintarUbicacionFisica(datos);
        }
    });
}

$( document ).ready(function() {
    obtenerUbucacionFisica();
});
