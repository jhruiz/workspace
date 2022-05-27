/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
   $("#btn_guardar").bind("click",function(){       
       enviarFormularioAjax();
   });
});

/**
 * Funcion que valida y envia el formulario para la asignacion del paquete al nuevo usuario , se envia 
 * por ajax y se muestra un mensaje de exito o fallo
 * 
 * @returns {undefined}
 */
function enviarFormularioAjax(){
    ///se valida el formulario
    var formValido = validaFormAsignaUsuarioPaquete();
       
       var paquete_id=$("#paquete_id").val();
       var usuario_id=$("#usuarioasignar").val();
       var paquetesusuario_id=$("#paquetesusuario_id").val();

       if(formValido){
           $.ajax({
               url: $('#url-proyecto').val() + "paquetesusuarios/cambiarpaqueteusuario",
               type: "POST",
               dataType: "json",
               data: {paquete_id: paquete_id, usuario_id: usuario_id, paquetesusuarioactual_id: paquetesusuario_id},
               success: function(data){
                   var datos=eval(data);

                   if(datos.estado == '1'){
                       ///Esta variable contiene el dialog, es global, se crea en infopaquete.js                                            
                       bootbox.alert("Se asignó el oficio al usuario correctamente", function(){
                           dialogAsignaUsuario.dialog('close');  
                       });
                   }else{
                       ///Esta variable contiene el dialog, es global, se crea en infopaquete.js                                              
                       bootbox.alert("No se asignó el oficio correctamente. Por favor, inténtelo de nuevo", function(){
                           dialogAsignaUsuario.dialog('close');
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
function validaFormAsignaUsuarioPaquete(){
    
    var valido=false;
    
    if($("#usuarioasignar").length > 0 && $("#usuarioasignar").val() > 0 && 
            $("#usuarioasignar").val() != "" && $("#paquete_id").val() != ""  && $("#paquete_id").val() > 0 ){

        var usuarioSeleccionado= $("#usuarioasignar option:selected").text();
        var  confirmacion = confirm("Desea asignar el oficio al usuario " + usuarioSeleccionado);
        
        if(confirmacion){
           valido=true;
        }else{
            valido=false;
        }
    }else{
        bootbox.alert("Debe seleccionar un usuario al cual se le va a asignar el oficio.");
        valido=false;
    }
    
    return valido;
}

