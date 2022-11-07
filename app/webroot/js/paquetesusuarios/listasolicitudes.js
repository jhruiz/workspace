var opcdialogTraslado = {
        autoOpen: false,
        modal: true,
        width: 500,
        height: 300,
        position: [400, 10],
        show: {
            effect: "blind",
            duration: 1000
        },
        hide: function () {
        },
        close: function( event, ui){          
        },
        title: 'Traslado Solicitudes'    
};

var dialogTraslado;  


//Se obtienen los checkbox seleccionados del listado de solicitudes de un usuario
// y se buscan los usuarios con privilegios similares (permisos de bandeja y oficina) para el traslado de solicitudes
function obtenerUsuarioTraslado(){
    //limpiamos el select
    var selectUsr = $('#usrTraslado');    
    selectUsr.find('option').remove();
    var usuarioId = $('#usuarioId').val();
    
    var checkboxValues = new Array();
    $("input:checkbox:checked").each(function(){
            checkboxValues.push($(this).val());
    });     
    
    $.post(urlBase+'paquetes/obtenerUsuarioGestion', {
        paqueteIds : checkboxValues,
        usuarioId : usuarioId
    }, function(responseText){
        var respuesta = JSON.parse(responseText); 
        var listaUsuario;
        for(var i = 0; i < respuesta.length; i ++){
            listaUsuario += "<option value='" + respuesta[i]["id"] + "'>" + respuesta[i]["nombre"] + "</option>";            
        }
        $('.traslado select').html(listaUsuario).fadeIn();
    });     

}


//Funcion que realiza el traslado de las solicitudes seleccionadas al usuario seleccionado
function trasladarSolicitudesSeleccionadas(){ 
 
    var mensaje = "";
    mensaje = validarFormulario();    
    if(mensaje != ""){
        bootbox.alert(mensaje);
    }else{
        //Se obtiene el motivo por lo cual se realiza el traslado
        trasladosolicitudes();
    }
}

function validarFormulario(){
    var mensaje = "";
    var usuario = $('#usrTraslado').val();
    var chkSelect = $(".chkObtenerUsr input:checked").length;  

    if(chkSelect <= 0){
        mensaje += "- Debe seleccionar al menos una solicitud para trasladar <br>";
    }    
    
    if(usuario == null || usuario == ""){
        mensaje += "- Debe seleccionar un usuario para el traslado de solicitudes <br>";
    }
    
    return mensaje;
}

function trasladosolicitudes(){
    $("#div_traslado").load(
        
        $('#url-proyecto').val() + "paquetesUsuarios/formtrasladosolicitudes",
        {
        },
        function(){ 
            dialogTraslado = $("#div_traslado").dialog(opcdialogTraslado);
            dialogTraslado.dialog('open');                                    
        }
    );      
}