
var dialogDocumento;
var url;  //Url del archivo a descargar
var dialogObservaciones; // Se muestra para agregar los motivos por los cuales se elimina un documento
var urlElimDoc; // url del archivo a eliminar
var paqueteIdElimDoc; // id del paquete que contiene el archivo a eliminar
var dialogDocumentosTemporales; //Se muestran los tipos documentales de los paquetes temporales a gestionar
var nombrePaciente; //Se captura el nombre del paciente para el nombre del archivo a descargar

//con el onReady se le aplica el datapicker a los campos de tipo feha
$(function() {
    var MaxInputs = 15; //Número Maximo de Campos
    var contenedor = $("#contenedor"); //ID del contenedor
    var AddButton = $("#agregarCampo"); //ID del Botón Agregar
    var buscar = $('#buscar');

    //var x = número de campos existentes en el contenedor
    var x = $("#contenedor div").length + 1;

    var FieldCount = x - 1; //para el seguimiento de los campos

    $(AddButton).click(function(e) {

        if (x <= MaxInputs)
        {

            $.ajax({
                type: 'POST',
                async: false,
                url: $('#url-proyecto').val()+'documentos/obtenerdocumentos',
                success: function(data){ 
                    var respuesta = JSON.parse(data);
                    
                    FieldCount++;

                    var select = "<br>Tipo Documento: ";
                    select += '<select name="data[Bandejatipo][tipoDoc_' + FieldCount + ']" id="nombreDocumento">';
                    $.each(respuesta, function(i, val) {
                        select += "<option value='" + i + "'>" + val + "</option>" 
                    });
                    select += '</select>';
			
                    //agregar campo
                    $(contenedor).append('<div>' + select + '<br><input type="file" name="data[Bandeja][documento_' + FieldCount + ']" class="buttonC white" id="BandejaArchivo"><a href="#" class="eliminar">&times;</a> </div>');
        
                    x++; //text box increment
                }
            });
        }
        return false;
    });
    


    $("body").on("click", ".eliminar", function(e) { //click en eliminar campo
        if (x > 1) {
            $(this).parent('div').remove(); //eliminar el campo
            x--;
        }
        return false;
    });

    $('#selDocPaq').change(cambiarDocumentoVisor);

    var estado = $('#estadoProcesoActual').val();
    if (estado == 10) {
        $('.chkDocs').attr("checked", "checked");
    } else {
    }

    $(".date").datepicker({dateFormat: 'yy-mm-dd'});
    $(".date").datepicker("option", "showAnim", "slideDown");
    $('#guardar').attr("disabled", "disabled");

});


function validarDatosCargueMasivo(Admision, Cedula) {
    var mensaje = "";
    if (Admision == "") {
        mensaje += '- Debe ingresar el número de Póliza \n';
    }
    if (Cedula == ""){
        mensaje += '- Debe ingresar el número de Referencia';
    }
    return mensaje;
}



function guardarObserv(nombreUsuario) {    
    var obsAnt = $('#obsGeneral').val();
    var date = new Date();
    var month = date.getMonth() + 1;
    var day = date.getDate();
    var year = date.getFullYear();
    var hora = date.getHours();
    var minutos = date.getMinutes();
    var segundos = date.getSeconds();
    var dateF = day + '/' + month + '/' + year + " " + hora + ":" + minutos + ":" + segundos;
    var obsFinal = obsAnt + '\n';
    obsFinal += "Fecha: " + dateF + '\n';
    obsFinal += "Usuario: " + nombreUsuario + '\n';
    obsFinal += $('#observacion').val() + '\n';
    obsFinal += "___";

    $('#obsGeneral').val(obsFinal);
    $('#observacion').val('');
}


function buscarPaquetes() {
    var numeroReferencia = $('#BandejaNumeroReferencia').val();
    var nombreProducto = $('#BandejaNombreProducto').val();
    var tipoMovimiento = $('#BandejaTipomovimiento').val();

    var url = "" + window.location;
    var newUrl = "";
    var arrUrl = url.split('/');
    var tamArrUrl = arrUrl.length;

    if (tamArrUrl < 11) {
        newUrl = window.location + "/";
    } else {
        var i = 0;
        for (i = 0; i < (arrUrl.length - 4); i++) {
            newUrl += arrUrl[i] + "/";
        }
    }

    var datosFiltros = "";

    if (numeroReferencia != "") {
        datosFiltros += numeroReferencia + "/";
    } else {
        datosFiltros += "empt/";
    }
    if (nombreProducto != "") {
        datosFiltros += nombreProducto + "/";
    } else {
        datosFiltros += "empt/";
    }
    if (tipoMovimiento != "") {
        datosFiltros += tipoMovimiento + "/";
    } else {
        datosFiltros += "empt/";
    }
    window.location.href = newUrl + datosFiltros;
}

function guardarFormulario() {
    document.getElementById("BandejaGuardarValoresCamposForm").submit();
}

function validarCargue() {
    var resp;
    var mensaje = "";
    var Archivo = $('#BandejaArchivo').val();
    
    mensaje = validarDatosCargue(Archivo);

    if (mensaje != "") {
        bootbox.alert(mensaje);
        resp = false;
    } else {
        resp = true;
    }
    return resp;
}

function validarDatosCargue(Archivo) {
    var mensaje = "";
    if (Archivo == "") {
        mensaje += '- Debe cargar un Archivo con extension .pdf <br>';
    }
    
    if(mensaje == ""){
        $( "input:file" ).each(function() {
            var file = $(this).val();
            var ext = file.split('.').pop();
            var name = file.split('\\').pop();
            var fileSize = $(this)[0].files[0].size;
            var maxSize = '1900000';
            if(fileSize > maxSize){
                mensaje += '- El archivo: ' + name + ' supera el peso permitido de 1.9 Mb <br>';
            }
            
            if(ext != 'pdf' && ext != 'PDF'){
                mensaje += '- Archivo invaldio: ' + name + '. Solo se permiten archivos con extension .pdf <br>' ;
            }
        });        
    }
    return mensaje;
}

function validacionReporte(form){
	var fechInicio = $('#SolicitudreporteFechaInicio').val();
	var fechFin = $('#SolicitudreporteFechaFin').val();
	if((fechInicio == "" || fechInicio == null) || (fechFin == "" || fechFin == null)){
		bootbox.alert('Debe seleccionar un rango de fechas para el reporte');
	}else{
		form.submit(); 
	}        
}

var cambiarDocumentoVisor = function(){
    var dir = $('#selDocPaq').find(':selected').data('dir');
    var urlDocs = $('#urlDocs').val();

    var visor = "<object data=" + urlDocs + dir + " type='application/pdf' width='100%' height='100%'></object>";

    $('#portapdf').html(visor);
    
}