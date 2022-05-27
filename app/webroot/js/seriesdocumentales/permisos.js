///////// PERMISOS /////////////
$('#permisos_tabs a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
});

function agregarPermisoCargoATabla(fila) {

    var tr = $('<tr>');
    tr.attr('id', 'Permisoscargo_' + fila.Permisodoccargopadredoc.id);
    tr.append('<td>' + fila.Cargo.nombre + '</td>');
    tr.append('<td>' + fila.Permisodoc.nombre + '</td>');
    tr.append('<td><a onclick="borrarPermisoCargo(' + fila.Permisodoccargopadredoc.id + ')"><i class="icon-trash"></i> Borrar</a></td>');

    $('#tablaPermisoCargo tbody').append(tr);
}

function agregarPermisoUsuarioATabla(fila) {

    var tr = $('<tr>');
    tr.attr('id', 'Permisousuario_' + fila.Permisodocusuariopadredoc.id);
    tr.append('<td>' + fila.Usuario.nombre + '</td>');
    tr.append('<td>' + fila.Permisodoc.nombre + '</td>');
    tr.append('<td><a onclick="borrarPermisoUsuario(' + fila.Permisodocusuariopadredoc.id + ')"><i class="icon-trash"></i> Borrar</a></td>');

    $('#tablaPermisoUsuario tbody').append(tr);
}

function abrirDialogoPermisos(idPadreDocumental) {
    $.post(urlPermisosCargoTipoDocumental, {
        idPadreDocumental: idPadreDocumental
    }, function (responseText) {
        $('#tablaPermisoCargo tbody').empty();
        $('#tablaPermisoUsuario tbody').empty();

        var respuesta = JSON.parse(responseText);
        console.log(respuesta);

        if (respuesta.cargos)
            for (var i = 0; i < respuesta.cargos.length; i++)
                agregarPermisoCargoATabla(respuesta.cargos[i]);

        if (respuesta.usuarios)
            for (var i = 0; i < respuesta.usuarios.length; i++)
                agregarPermisoUsuarioATabla(respuesta.usuarios[i]);
//
        $('#dialogoPermisos').data('idPadreDocumental', idPadreDocumental);
        $('#dialogoPermisos').modal('show');
        $('#permisos_tabs a:first').tab('show')
    });
}

function agregarPermisoCargo() {
    $.post(urlAddCargosPermisos, {
        padredocumentale_id: $('#dialogoPermisos').data('idPadreDocumental'),
        cargo_id: $('#cargo').val(),
        permisodoc_id: $('#permiso').val()
    }, function (responseText) {
        var respuesta = JSON.parse(responseText);
        console.log(respuesta);

        //pongo el cargo recien guardado en la tabla.
        if (respuesta.cargos){
            $('#mensaje_respuesta_permiso_cargo').show();
            agregarPermisoCargoATabla(respuesta.cargos[0]);
        }

        //vuelvo y cargo la pestaña de usuarios porque pudo haber cambiado
        $('#tablaPermisoUsuario tbody').empty();
        for (var i = 0; i < respuesta.usuarios.length; i++)
            agregarPermisoUsuarioATabla(respuesta.usuarios[i]);
    });
}

function borrarPermisoCargo(idPermisoscargo) {

    if (confirm('Esta seguro de borrar este permiso?'))
        $.post(urlDelCargosPermisos, {
            id: idPermisoscargo,
            padredocumentale_id: $('#dialogoPermisos').data('idPadreDocumental')
        }, function (responseText) {
            var respuesta = JSON.parse(responseText);
            if (respuesta.cargos) {
                alert('Permiso Borrado!');
                $('#tablaPermisoCargo tbody tr#Permisoscargo_' + idPermisoscargo).remove();

                //vuelvo y cargo la pestaña de usuarios porque pudo haber cambiado
                $('#tablaPermisoUsuario tbody').empty();
                for (var i = 0; i < respuesta.usuarios.length; i++)
                    agregarPermisoUsuarioATabla(respuesta.usuarios[i]);
            }
            else
                alert('Error al borrar!');
        })
}

function agregarPermisoUsuario(){
    $.post(urlAddUsuariosPermisos, {
        padredocumentale_id: $('#dialogoPermisos').data('idPadreDocumental'),
        usuario_id: $('#usuario').val(),
        permisodoc_id: $('#permisousuario').val()
    }, function(responseText){
        var respuesta = JSON.parse(responseText);
        if(respuesta){
            $('#mensaje_respuesta_permiso_usuario').show();
            agregarPermisoUsuarioATabla(respuesta[0]);
        }
    });
}

function borrarPermisoUsuario(idPermisosuario){

    if(confirm('Esta seguro de borrar este permiso?'))
        $.post(urlDelUsuariosPermisos, {
            id: idPermisosuario,
            padredocumentale_id: $('#dialogoPermisos').data('idPadreDocumental')
        }, function(responseText){
            var respuesta = JSON.parse(responseText);
            if(respuesta == 1) {
                alert('Permiso Borrado!');
                $('#tablaPermisoUsuario tbody tr#Permisousuario_'+idPermisosuario).remove();
            }
            else if( respuesta == 2)
                alert('Error al borrar !');
            else if( respuesta == 3)
                alert('Este permiso no se puede borrar porque fue asignado por cargo');
        })
}
