/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    
    ///Se deshabilita el campo de confirmacion 
    $("#txtConfPass").val("");
    $("#UsuarioPassword").val("");
    $("#txtConfPass").prop("disabled", "disabled");    
    
    $("#UsuarioPassword").bind("blur",function(){
        ingresaContrasena();
    });
    
    $("#txtConfPass").bind("blur",function(){
        validarConfirmacionContras();
    });
    
});

function ingresaContrasena(){

    if($("#UsuarioPassword").val()==""){        
        $("#txtConfPass").val("");
        $("#txtConfPass").prop("disabled", "disabled");
    }else{
        $("#txtConfPass").removeAttr("disabled");
    }    
}


function validarConfirmacionContras(){
    var confirmContra=$("#txtConfPass").val();
    var contrasena=$("#UsuarioPassword").val();

    var valido=false;
    
    if(contrasena!=""){
        if(contrasena==confirmContra){
            valido=true;
        }
        else{
            bootbox.alert("La contraseña y su validación deben ser iguales");           
        }
    }else{
        $("#txtConfPass").val("");
        bootbox.alert("Debe ingresar una contraseña valida.");
    }

    
    ///Si existe el campo de contrasena anterior, se debe validar si realmente corresponde a la contraseña anterior del usuario.
    if($("#UsuarioPasswordA").length>0){
        valido=validarContrasenaAnterior($("#UsuarioPasswordA").val(),$("#selusuario").val());
    }

    return valido;
}



function validarContrasenaAnterior(contrasena,usuario){
    var valido=false;
    
    $.ajax({
        url:'validarcontrasenaantes',
        async: false,
        type: "post",
        data: {contrasenaAnt: contrasena, usuario: usuario},
        dataType: "json",
        success: function(data){
            var datos=eval(data);

            if(datos.estado){
                if(datos.valido){
                    valido=true;
                }else{
                    bootbox.alert("La contraseña anterior no coincide con la del usuario. Por favor verificar");
                }
            }else{
                bootbox.alert("No se pudo confirmar la contraseña anterior, por favor intentelo de nuevo.");
            }
        }
    });
    
    return valido;
}



