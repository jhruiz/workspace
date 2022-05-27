
    //valida que el password ingresado sea igual al de la confirmación. Jaiber Ruiz 13/Octubre/2013
    function validarContrasenia(){
        var pass1 = $('#UsuarioPassword').val();    
        var pass2 = $('#txtConfPass').val();

        if(pass1 != pass2){
            alert('El password y la confirmación no son iguales');
        }
    }

    function obtenerCiudades(){
        var options = $("#RegionaleId option:selected" ).val();
        //alert(options);

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
    
    function obteneroficinas(){  

        var options = $("#CiudadeId option:selected" ).val();
        var obtenerUsuarios=1;
        
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
    
    var nuevoUsuario = function(){
        window.location.href = $('#url-proyecto').val() + "usuarios/add";
    };