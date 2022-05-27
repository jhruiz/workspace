/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
   $("#btn_guardarEst").bind("click",function(){       
       enviarFormularioAjax();
   });
});

/**
 * Funcion que valida y envia el formulario para el cambio de estado, se envia 
 * por ajax y se muestra un mensaje de exito o fallo
 * 
 * @returns {undefined}
 */
function enviarFormularioAjax(){
    
       ///se valida el formulario
       var formValido = validaFormAsignaEstadoPaquete();
       var paquete_id=$("#paquete_id").val();
       var estado_id=$("#estadoasignar").val();
       var paquetesusuario_id=$("#paquetesusuario_id").val();       

        if(formValido){

           $.ajax({
               url: $('#url-proyecto').val() + "estados/cambiarpaqueteestado",
               type: "POST",
               dataType: "json",
               data: {paquete_id: paquete_id, paquetesusuarioactual_id: paquetesusuario_id, estado_id:estado_id},
               success: function(data){
                   var datos=eval(data);
                   if(datos.estado){
                       ///Esta variable contiene el dialog, es global, se crea en infopaquete.js                       
                       bootbox.alert("Se realizó el cambio de estado correctamente", function (){
                           dialogCambiarBandejaOficio.dialog('close');
                       });
                   }else{                       
                       bootbox.alert("NO se realizó el cambio de estado. Por favor, inténtelo de nuevo. De persistir, comuniquese con el administrador", function (){
                           dialogCambiarBandejaOficio.dialog('close');
                       });
                   }
                   
               }                       
           });
       }
}


/**
 * Funcion que valida el formulario para cambiar el usuario encargado de un paquete
 * 
 * @returns {Boolean}
 */
function validaFormAsignaEstadoPaquete(){
    
    var valido=false;
    
    if($("#estadoasignar").length > 0 && $("#estadoasignar").val() > 0 && 
            $("#estadoasignar").val() != "" && $("#paquete_id").val() != ""  && $("#paquete_id").val() > 0 ){

        var estadoSeleccionado = $("#estadoasignar option:selected").text();
        var  confirmacion = confirm("Desea enviar el oficio al estado " + estadoSeleccionado);
        if(confirmacion){
           valido=true;
        }else{
            valido=false;
        }
    }else{
        bootbox.alert("Debe seleccionar un estado al cual enviar el oficio.");
        valido=false;
    }
    
    return valido;
}

