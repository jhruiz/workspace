/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var opcDialogAsignaUsuario = {
        autoOpen: false,
        modal: true,
        width: 450,
        height: 250,
        position: [400, 50],
        show: {
            effect: "blind",
            duration: 1000
        },
        hide: function () {
            $(this).dialog('destroy').remove();
        },
        close: function( event, ui){
            $(this).dialog('destroy').remove();
            location.reload();
        },
        title: 'Cambia Usuario Encargado del Paquete'
    };
    
    var dialogAsignaUsuario;
    
var opcCialogCambiarBandeja = {
        autoOpen: false,
        modal: true,
        width: 450,
        height: 250,
        position: [400, 50],
        show: {
            effect: "blind",
            duration: 1000
        },
        hide: function () {
            $(this).dialog('destroy').remove();
        },
        close: function( event, ui){
            $(this).dialog('destroy').remove();
            location.reload();
        },
        title: 'Cambiar Estado Oficio'    
};

var dialogCambiarBandejaOficio;


function cambiarUsuarioAsignado(paquete,paqueteUsuario,usuario_id){
    if(paquete > 0 && paqueteUsuario > 0){
        $("#div_asignausuario").load(
                $('#url-proyecto').val() + "paquetesusuarios/formcambiarusuariopaquete",
                {
                    paquete_id: paquete, paquetesusuario_id: paqueteUsuario, usuario_id: usuario_id
                },
                function(){                                                            
                    dialogAsignaUsuario=$("#div_asignausuario").dialog(opcDialogAsignaUsuario);
                    dialogAsignaUsuario.dialog('open');
                }
        );               
    }else{
        bootbox.alert("Falta informacion para cambiar el usuario asignado del paquete");
    }
}

function cambiarNumeroOficio(paqueteId){
        
    bootbox.confirm("¿Desea cambiar el número de oficio?", function (result) {
        if (result) {
            var numOficio = $('#numeroOficio').val();
            $.post($('#url-proyecto').val()+'bandejas/actualizarOficioPorAdminAjax', {
                numOficio : numOficio,
                paqueteId : paqueteId                
            }, function(responseText){
            var respuesta = JSON.parse(responseText);
                if(respuesta.bool){  
                    bootbox.alert(respuesta.respuesta);
                }
                else{
                    bootbox.alert(respuesta.respuesta);
                }                                
            });             
        }        
    });    
    
}

function cambiarEstadoOficio(paquete,paqueteUsuario,estado_id){
    if(paquete > 0 && paqueteUsuario > 0){
        $("#div_cambiobandeja").load(
                $('#url-proyecto').val() + "estados/formcambiarbandejapaquete",
                {
                    paquete_id: paquete, paquetesusuario_id: paqueteUsuario, estado_id: estado_id
                },
                function(){                                                            
                    dialogCambiarBandejaOficio=$("#div_cambiobandeja").dialog(opcCialogCambiarBandeja);
                    dialogCambiarBandejaOficio.dialog('open');
                }
        );               
    }else{
        bootbox.alert("Falta informacion para cambiar la bandeja del oficio");
    }
}

