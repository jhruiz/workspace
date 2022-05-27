/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function cambiaContrasenya(){    
    if($("#UsuarioPassword").val()!=""){           
        $("#txtConfPass").removeAttr("disabled");               
    }else{
        $("#txtConfPass").val("");
        $("#txtConfPass").prop("disabled","disabled");
    }      
}

function validarContrasenya(){
    
    var valido=false;
    
     if( $("#UsuarioPassword").val()!=""){
        if($("#UsuarioPassword").val()!== $("#txtConfPass").val() ){                   
            bootbox.alert("La contraseña y su confirmacion no coinciden. Por favor verificar.");
        }else{
            valido=true;
        }
    }
    
    return valido;
}


function validarFormUsu(){
    
    var valido=false;
    
    valido=validarContrasenya();
    
    return valido;
}


$(document).ready(function() {
    $("#mostrarZona1").attr('checked', true);
    obtenerCiudades();             
    
    if($("#UsuarioPassword").length>0){
    
        $("#UsuarioPassword").bind("blur", function(){
            cambiaContrasenya();
        });
         $("#UsuarioPassword").blur();    

     }
});

