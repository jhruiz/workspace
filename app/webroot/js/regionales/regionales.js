/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


////Obtener ciudades de una regional seleccionada
   function obtenerCiudades(){
    var options = $("#RegionaleId option:selected" ).val();
                $.ajax({
                    type: 'POST',
                    async: false,
                    url: $('#url-proyecto').val()+'usuarios/obtenerciudades',
                    data: {opcion: options},
                    success: function(data){                        
                        $("#divCiudades").html(data);
//                        obteneroficinas();
                    }
                });
    }
    
    var nuevaRegional = function(){
        window.location.href = $('#url-proyecto').val() + "regionales/add";
    }



