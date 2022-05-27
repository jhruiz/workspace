function agregarSecuencia(){

    var idBandejaInicial = $.trim($('#bandeja_inicial').val());
    var idBandejaFinal = $.trim($('#bandeja_siguiente').val());
    var idEtiquetaCambio = $.trim($('#bandeja_etiqueta').val());    
    var analisisCargas = $('#analisiscargas').prop('checked');
    
    var mensaje = validarSecuenciaFlujo(idBandejaInicial, idBandejaFinal, idEtiquetaCambio);
    if(mensaje != ''){
        bootbox.alert(mensaje);
    }else{
        $.post(urlBase+'bandejas/addSecuencia', {
            bandejasflujo_id : idBandejaInicial,
            bandejasflujosig_id : idBandejaFinal,
            etiqutaCambio: idEtiquetaCambio,
            analisisCargas: analisisCargas
        }, function(responseText){    
            var respuesta = JSON.parse(responseText);
            if(respuesta.bool){  
                cerrarDialogoSecuencia();
            }else{
                bootbox.alert(respuesta.respuesta);
                $('#mensaje_respuesta_secuencia').addClass('alert-error').html('Ocurrió un error al guardar').show();
            }                                
        });            
    }
}

function cerrarDialogoSecuencia(){

    $('#addBandejaSecuencia').modal('hide');
    $('#mensaje_respuesta_secuencia').removeClass('alert-error').removeClass('alert-success').html('').hide();
    window.location.reload();
}

function borrarSecuencia(idSecuencia){
    if(confirm('Esta seguro de borrar esta secuencia?')){
        $.post(urlBase+'bandejas/borrarSecuencia',{
                id: idSecuencia
            },function(responseText){
                var respuesta = JSON.parse(responseText);
                if(respuesta) {
                    $("#flujosecuencia_"+idSecuencia).remove();
                    window.location.reload();
                }
                else{
                    alert('Esta bandeja no puede ser borrada porque pertenece a una secuencia')
                }
            });        
    }
}

///////// PERMISOS /////////////
$('#permisos_tabs a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
});

function agregarPermisoUsuarioATabla(fila){

    var tr = $('<tr>');
    tr.attr('id', 'Permisousuariobandeja_'+fila.Permisousuariobandeja.id);
    tr.append('<td>'+fila.Usuario.nombre+'</td>');
    tr.append('<td>'+fila.Permisobandeja.descripcion+'</td>');
    tr.append('<td><a onclick="borrarPermisoUsuarioBandeja('+fila.Permisousuariobandeja.id+')"><i class="icon-trash"></i> Borrar</a></td>');
    $('#tablaPermisoUsuarioBandeja tbody').append(tr);
}

function abrirDialogoPermisos(idBandeja, nombreBandeja){

    $.post(urlBase+'permisousuariobandejas/ajaxListPermisoPorBandeja', {
            idBandeja: idBandeja
        }, function (responseText) {
            $('#tablaPermisoUsuarioBandeja tbody').empty();
            var respuesta = JSON.parse(responseText);

            if(respuesta.infoPermisosBandeja){
                for(var i = 0; i < respuesta.infoPermisosBandeja.length; i++){
                    agregarPermisoUsuarioATabla(respuesta.infoPermisosBandeja[i]);
                }
            }
            
            $('#dialogoPermisos').data('idBandeja', idBandeja);
            $('#permisos_nombreBandeja').html(nombreBandeja);
            $('#dialogoPermisos').modal('show');
            $('#permisos_tabs a:first').tab('show');
        });
}

function agregarPermisoPerfilBandeja(data){
    
    var arrNameBtn = data.name.split("_");
    var idPerfil = arrNameBtn['1'];
    var idBandeja = $('#dialogoPermisos').data('idBandeja');
    var idPermiso = $('#permisoperfilbandeja_'+arrNameBtn['1']).val();

    if(idPermiso == undefined || idPermiso == '0'){
        bootbox.alert("Debe seleccionar un tipo de permiso");
    }else{
        $.post(urlBase+'permisousuariobandejas/addPermisosPerfil', {
            bandeja_id: idBandeja,
            perfil_id: idPerfil,
            permisobandeja_id: idPermiso
        }, function(responseText){
            var respuesta = JSON.parse(responseText);

            //vuelvo y cargo la pestaña de usuarios
            if(respuesta.usuarios == '1'){
                $('#mensaje_respuesta_permiso_perfil').show();
                $('#tablaPermisoUsuarioBandeja tbody').empty();
                    abrirDialogoPermisos(idBandeja);                   
            }else{
                bootbox.alert('Ya existe el permiso para el usuario');
            }

        });
        
    }
}

function agregarPermisoUsuarioBandeja(data){
    
    var arrNameBtn = data.name.split("_");
    var idUsuario = arrNameBtn['1'];
    var idBandeja = $('#dialogoPermisos').data('idBandeja');
    var idPermiso = $('#permisousuariobandeja_'+arrNameBtn['1']).val();
    
    $.post(urlBase+'permisousuariobandejas/add', {
        bandeja_id: idBandeja,
        usuario_id: idUsuario,
        permisobandeja_id: idPermiso
    }, function(responseText){
        var respuesta = JSON.parse(responseText);

        if(respuesta.respuesta == '1'){
            $('#mensaje_respuesta_permiso_usuario').show();
            $('#tablaPermisoUsuarioBandeja tbody').empty();
            abrirDialogoPermisos(idBandeja);
        }else if(respuesta.respuesta == '2'){
            bootbox.alert('Ya existe el permiso para el usuario');
        }
    });
}

function borrarPermisoUsuarioBandeja(idPermisosuariobandeja){
    if(confirm('Esta seguro de borrar este permiso?'))
        $.post(urlBase+'permisousuariobandejas/delete', {
            id: idPermisosuariobandeja,
            bandejasflujo_id: $('#dialogoPermisos').data('idBandejaFlujo')
        }, function(responseText){
            var respuesta = JSON.parse(responseText);
            if(respuesta == 1) {
                bootbox.alert('Permiso Eliminado!');
                $('#tablaPermisoUsuarioBandeja tbody tr#Permisousuariobandeja_'+idPermisosuariobandeja).remove();
            }
            else if( respuesta == 2){
                alert('Error al borrar !');
            }
        });
}

function validarSecuenciaFlujo(idBandejaInicial, idBandejaFinal, idEtiquetaCambio){
    
    var mensaje = '';
    
    if(idBandejaInicial == "" || idBandejaInicial == "0"){
        mensaje += "- Debe seleccionar una <b>bandeja inicial</b><br>";
    }
    
    if(idBandejaFinal == "" || idBandejaFinal == "0"){
        mensaje += "- Debe seleccionar una <b>bandeja final</b><br>";
    }
    
    if(idEtiquetaCambio == "" || idEtiquetaCambio == "0"){
        mensaje += "- Debe seleccionar una <b>etiqueta para cambio de estado</b><br>";
    }
    return mensaje;
}


////////SEMAFOROS////////

function abrirDialogoSemaforos(idBandeja, nombreBandeja){       

    $.post(urlBase+'bandejassemaforos/ajaxListBandejasSemaforos', {
            idBandeja: idBandeja
        }, function (responseText) {
            $('#tablaBandejasSemaforos tbody').empty();
            var respuesta = JSON.parse(responseText);

            if(respuesta.infoBandejasSemaforos){
                for(var i = 0; i < respuesta.infoBandejasSemaforos.length; i++){ 
                    agregarSemaforoBandejaATabla(respuesta.infoBandejasSemaforos[i]);
                }
            }
            
            $('#dialogoSemaforos').data('idBandeja', idBandeja);
            $('#semaforos_nombreBandeja').html(nombreBandeja);
            $('#dialogoSemaforos').modal('show');
            $('#bandejassemaforo_tabs a:first').tab('show');
                     
        });        
}

function agregarSemaforoBandeja(){
    var idSemaforo = $('#BandejasSemaforoSemaforoId').val();
    var idBandeja = $('#dialogoSemaforos').data('idBandeja');

    $.post(urlBase+'bandejassemaforos/agregarBandejaSemaforoConfig',{
        idBandeja: idBandeja,
        idSemaforo: idSemaforo
    }, function(responseText){
        var respuesta = JSON.parse(responseText);

        if(respuesta.respuesta == '1'){
            $('#mensaje_respuesta_semaforo_bandeja').show();
            $('#tablaBandejasSemaforos tbody').empty();
            abrirDialogoSemaforos(idBandeja);
        }else if(respuesta.respuesta == '2'){
            bootbox.alert('Ya existe el semáforo para la bandeja');
        }else if(respuesta.respuesta == '3'){
            bootbox.alert('No se pudo guardar el semáforo para la bandeja. Por favor, inténtelo de nuevo');
        }       
    });
        
}

function agregarSemaforoBandejaATabla(fila){

    var tr = $('<tr>');
    tr.attr('id', 'Bandejassemaforo_'+fila.BandejasSemaforo.id);
    tr.append('<td><div style=" border-width: 4px; border-radius: 25px; background-color:#' + fila.Semaforo.color + '; width:1px; padding:15px;"></div></td>');
    tr.append('<td>'+ fila.Semaforo.rango_inicial + "-" + fila.Semaforo.rango_final +'</td>');
    tr.append('<td><a onclick="borrarBandejaSemaforo('+fila.BandejasSemaforo.id+')"><i class="icon-trash"></i> Borrar</a></td>');
    $('#tablaBandejasSemaforos tbody').append(tr);  

}

function borrarBandejaSemaforo(idBandejaSemaforo){
    if(confirm('Esta seguro de borrar el semáforo para la bandeja?')){
        $.post(urlBase+'bandejassemaforos/borrarbandejasemaforo',{
                idBandejaSemaforo: idBandejaSemaforo
            },function(responseText){
                var respuesta = JSON.parse(responseText);
                if(respuesta) {
                    bootbox.alert('Semáforo Eliminado!');
                    $("#Bandejassemaforo_"+idBandejaSemaforo).remove();
                }
                else{
                    bootbox.alert('El semáforo no pudo ser eliminado. Por favor, inténtelo de nuevo');
                }
            });        
    }    
}

function cerrarDialogoBandejaSemaforo(){
    $('#dialogoSemaforos').modal('hide');
    $('#mensaje_respuesta_semaforo_bandeja').hide();    
}

