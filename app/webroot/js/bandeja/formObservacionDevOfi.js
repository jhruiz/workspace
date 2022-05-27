/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var obsRechazo;
var tamObsFinal;
var tamMotivoRechazo;

$(document).ready(function(){
   $("#btn_rechazoOf").bind("click",function(){  
       setObservacionDevolverOficio();
   });

   $("#btn_cancelarOf").bind("click",function(){  
       cancelarDevolverOficio();
   });    
   
   obsRechazo = $('#obsRechazo').val();
   tamObsFinal = obsRechazo.length;
});

function setObservacionDevolverOficio(){
    var mensaje = "";
    mensaje = validarDevolucion(); 
    
    if(mensaje != ""){
        bootbox.alert(mensaje);
    }else{
        $('#obsDevOfi').val($('#obsRechazo').val());
        $('#motivorechazo').val($('#motivosrechazo').val());
        dialogObservacionDevOf.dialog('close');
        guardarPaquete();        
    }
}

function cancelarDevolverOficio(){   
    $('#obsDevOfi').val("");
    $('#motivorechazo').val("");    
    dialogObservacionDevOf.dialog('close');
}

function validarDevolucion(){
    var mensaje = "";
    var tamObs = $('#obsRechazo').val().length;
    
    tamMotivoRechazo = $("#motivosrechazo option:selected").html().length;

    var difTamObs = tamObs - (tamObsFinal + tamMotivoRechazo);
    
    var motivo = $('#motivosrechazo').val();
    if(motivo == ""){
        mensaje = "- Debe seleccionar un motivo de rechazo. \n";
    }
    
    if(difTamObs < 21){
        mensaje = "- La observación debe contener al menos 20 caracteres. \n";
    }
    
    return mensaje; 
}

function agregarObservacion(dato){       
    var motivo = $("#motivosrechazo option:selected").html();        
    $('#obsRechazo').val(obsRechazo + motivo + '\n' );
    
}