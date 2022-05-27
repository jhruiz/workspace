
function agregarFila(){                   
    
        var fila = $('#tabla_distribucion tr.filaNueva:last').clone();

        var numero = parseInt(fila.find('input').data('indice'))+1;
        $('#tabla_distribucion tbody').append(fila);
        $('#tabla_distribucion tr.filaNueva:last input').attr('data-indice', numero).data('indice', numero).val('');
        $('#tabla_distribucion tr.filaNueva:last select').attr('id', 'centrocosto_'+numero);
        $('#tabla_distribucion tr.filaNueva:last').show();
        agregarFormatoNumeros();   
}

function borrarFila(element){
    $(element).parent().parent().remove();
}

function borrarDistribucion(id){
    $('#tabla_distribucion tr#distribucion_'+id).addClass('borrada').hide();
}

$(document).ready(function(){
    
    agregarFormatoNumeros();
});


function enviarFormulario(){

    $('#tabla_distribucion tr.error').removeClass('error');

    var filas = $('#tabla_distribucion tr.filaActual.borrada input');
    var montosBorrar = [];
    for(var i = 0; i < filas.length; i++){
        var campo = $(filas[i]);
        montosBorrar.push(campo.data('distribucion'));
    }


    var filas = $('#tabla_distribucion tr.filaActual:not(.borrada) input');
    var montosActualizar = {};
    var centrosCostoOriginales = [];
    for(var i = 0; i < filas.length; i++){

        var campo = $(filas[i]);

        var valor = campo.val();
        var valorFloat = parseFloat(valor);


        centrosCostoOriginales.push(parseFloat(campo.data('centrocosto')));

        if(!isNaN(valorFloat) && valorFloat > 0)
            montosActualizar['d_'+campo.data('distribucion')] = valorFloat;
        else {
            campo.focus();
            alert('Hay un Valor Inválido, los valores deben ser numeros mayores a 0. ');
            return false;
        }
    }


    


    var montosEnviar = {};
    var filas = $('#tabla_distribucion tr.filaNueva:visible input');
    for(var i = 0; i < filas.length; i++){
        var campo = $(filas[i]);
        var numero = campo.data('indice');
        var centro = parseFloat($('#centrocosto_'+numero).val());

        if(!montosEnviar.hasOwnProperty('c_'+centro) && centrosCostoOriginales.indexOf(centro) == -1){
            var valor = campo.val();
            var valorFloat = parseFloat(valor);
            if(!isNaN(valorFloat) && valorFloat > 0)
                montosEnviar['c_'+centro] = valorFloat;
            else {
                campo.focus();
                alert('Hay un Valor Inválido, los valores deben ser numeros mayores a 0. ');
                return false;
            }
        }
        else{
            //error en la fila
            campo.parent().parent().addClass('error');
            campo.focus();
            console.log(montosEnviar);
            alert('Hay un Centro de Costo Repetido');
            return false;
        }            
    }


    //verificar el total
    var total = 0;
    for(var m in montosEnviar)
        total += montosEnviar[m];
    for(var m in montosActualizar)
        total += montosActualizar[m];


    var totalOriginal = parseFloat($('#total_factura').val())
    if(total == totalOriginal) {
        
        var idPaquete = $('#id_paquete').val()
        $.post(urlBase+'paquetes/distribuirPaquete/'+idPaquete, {
                montos: JSON.stringify(montosEnviar),
                montosActualizar: JSON.stringify(montosActualizar),
                montosBorrar: JSON.stringify(montosBorrar),
                num_factura: $('#num_factura').val()
            }, function(responseText){
                var respuesta = JSON.parse(responseText);
                if(respuesta){
                    alert('Distribución Exitosa');
                    window.location.reload();
                }
                else
                    alert('Error al Distribuir');
        });
        return true;
    } else {
        alert('Se debe distribuir el monto total de la factura('+$.number(totalOriginal,2)+'). El monto distribuido hasta el momento es de '+$.number(total,2));
        return false;
    }


}


