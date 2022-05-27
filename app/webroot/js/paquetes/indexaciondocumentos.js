var dialogSeleccionarOficio = {
    autoOpen: false,
    modal: true,
    width: 1000,
    height: 400,
    position: [400, 50],
    show: {
        effect: "blind",
        duration: 1000
    },
    hide: function () {
        $(this).dialog('destroy').remove();
        $("#cont_divSelOficio").append("<div id='div_seleccionoficio'></div>");
    },
    close: function( event, ui){
        $(this).dialog('destroy').remove(); 
        $("#cont_divSelOficio").append("<div id='div_seleccionoficio'></div>");
    },
    title: 'Selección de Solicitud'    
};

var seleccionarOficio;


/*
 * Permite cargar el archivo a indexar de manera temporal y generar el archivo 
 * djvu, para luego poderlo visualizar
 */
 function cargarArchivos() {    
    $('#DocumentospaqueteCarguearchivosForm').submit();        
}

function abrirDialogoSeleccionOficio(listaSolicitud, permisoCrear){

    $("#div_seleccionoficio").load(
        $('#url-proyecto').val() + "paquetes/formseleccionoficiocarguearchivos",
        {
            arrSolicitud: listaSolicitud, permisoCrear: permisoCrear
        },
        function(){                                                            
            seleccionarOficio=$("#div_seleccionoficio").dialog(dialogSeleccionarOficio);
            seleccionarOficio.dialog('open');
        }
        );               
}  

function obtenerOficioSeleecion(){
    var oficioSel = $('input:radio[name=oficio]:checked').val();
    if(oficioSel == "" || oficioSel == undefined){
        bootbox.alert('Debe seleccionar un Solicitud para adjuntarle documentos.');
    }else{          
        var solicitud = $('#s_'+oficioSel).val();

        bootbox.confirm("¿Está seguro que desea seleccionar la Solicitud Número " + solicitud + "?", function (result) {
            if(result){                
                //Cerrar el dialogo y que se preseleccionen los campos de ubicación.                
                $('#formCargue').removeAttr("style");                  
                $('#inputReg').removeAttr("style");
                $('#inputCiu').removeAttr("style");                
                $('#inputOfi').removeAttr("style");
                
                $('#regNombre').val($('#rd_'+oficioSel).val());                
                $('#ciuNombre').val($('#cd_'+oficioSel).val());
                $('#ofiNombre').val($('#od_'+oficioSel).val());
                $('#oficinaId').val($('#o_'+oficioSel).val());
                $('#DocumentospaqueteOficioId').val(oficioSel);
                
                seleccionarOficio.dialog('close');
            }
        });               
    }    
}

function estadoCargueArchivos(estadoId){
    var resp = false;    
    $.ajax({
        method: 'POST',
        url: $('#url-proyecto').val() + 'estados/AjaxEstadoCargueArchivos',
        data: {estadoId : estadoId},
        async: false,
        success: function(data) {
            var respuesta = JSON.parse(data);
            if(respuesta.bool == 'true'){
                resp = true;
            }
        }        
    });    
    return resp;
}

function validarSolicitud(){
   $('#trazaPaqModal').modal('hide');
    ocultarFormulario();
    var numeroDocumento = $('#DocumentospaqueteNumeroDocumento').val();
    
    $.ajax({
        method: 'POST',
        url: $('#url-proyecto').val() + 'documentospaquetes/ajaxValidarSolicitud',
        data: {numeroDocumento : numeroDocumento.trim()},
        async: false,
        success: function(data){
         var respuesta = JSON.parse(data);
         if(respuesta.M != "" && respuesta.S == "" && respuesta.P == ""){
            bootbox.alert(respuesta.M);
        }

        if(respuesta.M == "" && respuesta.S != "" && respuesta.P != ""){
            abrirDialogoSeleccionOficio(respuesta.S, respuesta.P);
        }

        if(respuesta.M == "" && respuesta.S == "" && respuesta.P != ""){
            nuevasolicitud('0');
        }          
    }
});
}


function validarCredecialesServicioWeb(){
    var tipoDocumento = $('#DocumentospaqueteTipoDocumento option:selected').text();
    var numeroDocumento = $('#DocumentospaqueteNumeroDocumento').val();
    $.ajax({
        method: 'POST',
        url: $('#url-proyecto').val() + 'documentospaquetes/mostrarProgramaCredenciales',
        data: {tipoDocumento : tipoDocumento,numeroDocumento : numeroDocumento},
        async: false,
        success: function(data){
            $('#div_trazabilidad').html(data);
            $('#trazaPaqModal').modal("show");
            $('#trazaPaqModal').css({'position':'fixed'});    
        }
            /*var response = JSON.parse(data);
            var cod_error = response.errorBean;
            if(cod_error.codigo == "0"){
                var sel = $('<select>').appendTo('body');
                $(response.credencialesDTO).each(function() {
                   sel.append($("<option>").attr('value',this.val).text(this.text));
               });
                debugger;
                for (var i = response.credencialesDTO.length - 1; i >= 0; i--) {
                    
                }
            }*/
            

        });
}

function nuevasolicitud(dato){ 

    var solicitud = $('#DocumentospaqueteNumeroDocumento').val();
    if(solicitud == "" || solicitud == null){
        bootbox.alert('El campo Número no puede estar vacio.');
    }else{
        bootbox.confirm("¿Está seguro que desea crear una nueva petición?", function (result) {

            if(result){             
                    //Cerrar el dialogo y que se preseleccionen los campos de ubicación.                
                    $('#formCargue').removeAttr("style");               
                    $('#selectReg').removeAttr("style");
                    $('#selectCiu').removeAttr("style");                
                    $('#selectOfi').removeAttr("style");                
                    $('#selectReg').removeAttr("style");
                    $('#selectCiu').removeAttr("style");                
                    $('#selectOfi').removeAttr("style");
                    $('#selectEst').removeAttr("style");
                    if(dato == '1'){
                        seleccionarOficio.dialog('close');                        
                    } 
                }
            });             
    }
}

function ocultarFormulario(){
    $('#formCargue').attr("style", "display:none");                  
    $('#selectReg').attr("style", "display:none");
    $('#selectCiu').attr("style", "display:none");                
    $('#selectOfi').attr("style", "display:none"); 
    $('#inputReg').attr("style", "display:none");
    $('#inputCiu').attr("style", "display:none");                
    $('#inputOfi').attr("style", "display:none"); 
    $('#DocumentospaqueteOficioId').val("");
    $('#oficinaId').val("");
    $('#BandejaArchivo').val("");
}

function checkForOther(data){
    $('#credencial').find('option')
    .remove().end()
    .append('<option>Seleccione uno</option>');
    var valor = $('#programa option:selected').val();
    var responseWS = JSON.parse($('#responseWS').val());
        //No se crea una lista de opciones ya que la credencial Sias no llego con valor
        if(valor.length > 0){
            $('#credencial').append($("<option></option>")
                .attr("value", 0)
                .text(responseWS.credencialesDTO[valor].credencialesA)); 
            if(responseWS.credencialesDTO[valor].credencialesS != null){
                $('#credencial').append($("<option></option>")
                    .attr("value",1)
                    .text(responseWS.credencialesDTO[valor].credencialesS)); 
            }
        }else{
            $('#credencial').find('option')
            .remove().end()
            .append('<option>Seleccione uno</option>');
        }
    }


    $(function(){
        var paqueteId = $('#DocumentospaquetePaqueteId').val();

        if(paqueteId != "" || paqueteId != null){
            $.ajax({
                url: $('#url-proyecto').val() + "paquetes/AjaxObtenerInfoPaqute",
                data:{paqueteId: paqueteId},
                dataType:"json",
                type:"post",
                async: false,
                success:function(data){
                    var datos = eval(data);
                    console.log(datos);
                    $('#formCargue').removeAttr("style");                  
                    $('#inputReg').removeAttr("style");
                    $('#inputCiu').removeAttr("style");                
                    $('#inputOfi').removeAttr("style");
                    $('#DocumentospaqueteNumeroDocumento').val(datos.credencial);
                    $('#DocumentospaqueteNumeroDocumento').attr('readonly', true);
                    $('#regNombre').val(datos.regionalDesc);                
                    $('#ciuNombre').val(datos.ciudadDesc);
                    $('#ofiNombre').val(datos.oficinaDesc);
                    $('#oficinaId').val(datos.oficinaId);
                    $('#DocumentospaqueteOficioId').val(paqueteId);
                }
            });            
        }
    });



