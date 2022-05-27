/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function mostrarTrazabilidad(paqueteId, nombreBandeja, idDivTraza) {

    if (paqueteId > 0) {
        $.post($('#url-proyecto').val() + 'trazabilidades/mostrarTrazabilidad',
                {
                    paquete_id: paqueteId, nombre_bandeja: nombreBandeja
                },
        function (responseText) {
            $('#' + idDivTraza).html(responseText);
            $('#trazaPaqModal').modal("show");
            $('#trazaPaqModal').css({'width': '760px', 'left': '45%'});


        });
    }
}

