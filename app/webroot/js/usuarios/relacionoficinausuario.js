    //Se carga la funcion obtenerCiudades al recargar la pagina
    $(function(){    
       obtenerCiudades(); 
    });

    //Función que obtiene las ciudades a partir de la regional seleccionada por ajax
    function obtenerCiudades(){
        var options = $("#RegionaleId option:selected" ).val();
                $.ajax({
                    type: 'POST',
                    async: false,
                    url: $('#url-proyecto').val() + 'usuarios/obtenerciudades',
                    data: {opcion: options},
                    success: function(data){
                        $("#divCiudades").html(data);
                        obteneroficinas();
                    }
                });               
    }
    
    //Función que obtiene las oficinas a partir de la ciudad seleccionada por ajax, el listado desde esta función se un select multiple    
    function obteneroficinas(){  

        var options = $("#CiudadeId option:selected" ).val();
        var obtenerUsuarios=0;
        
        $.ajax({
            type: 'POST',
            async: false,
            url: $('#url-proyecto').val() + 'usuarios/obteneroficinas',
            data: {opcion: options, obtenerUsuarios: obtenerUsuarios},
            success: function(data){  
                $("#divOficinas").html(data);
            }
        });        
    }

