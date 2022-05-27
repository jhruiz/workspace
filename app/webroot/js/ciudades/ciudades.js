/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

////Obtiene las oficinas de una ciudad selecccionada previamente
function obteneroficinas(){  
    
        var options = $("#CiudadeId option:selected" ).val();
        var obtenerUsuarios=0;

        //Si la finalidad es obtener los usuarios de la oficina
        if($("#obtener_usuarios").length > 0){
            obtenerUsuarios=1;
        }
        
        $.ajax({
            type: 'POST',
            async: false,
            url: $('#url-proyecto').val()+'usuarios/obteneroficinas',
            data: {opcion: options, obtenerUsuarios: obtenerUsuarios},
            success: function(data){  
                $("#divOficinas").html(data);
                if($("#obtener_usuarios").length > 0){
//                    obtenerUsuariosDeOficina();
                }
            }
        });
    }
    
    var nuevaCiudad = function(){
        window.location.href = $('#url-proyecto').val() + "ciudades/add";
    };