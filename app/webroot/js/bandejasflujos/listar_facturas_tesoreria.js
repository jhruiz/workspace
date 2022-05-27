function validarFacturasTesoreria(){
    
    var valido=true;
    
    ///Se valida que para todas las facturas que se definan como cargadas correctamente se haya seleccionado un flujo de tesorerias
    $(".cls_selflujotesoreria").each(function(){
                
        var parent = $(this).parent().parent().parent();
        var checkCargadoHermano = parent.find('input.cargado');                
        
        if(checkCargadoHermano.is(":checked")){
            var flujotesoreria=$(this).val();                                                
            
            if(flujotesoreria==null  || flujotesoreria=="" || flujotesoreria<=0){
                valido=false;
            }
        }
        
        return valido;
    });        
    
    if(!valido){
        bootbox.alert("Para todas las facturas seleccionadas debe ingresar un flujo de tesoreria.");
    }
    
    return valido;
}


var fnClickExcel = function () {
    var parent = $(this).parent().parent();
    var checkCargadoHermano = parent.find('input.cargado');

    if ($(this).is(":checked")) {
        checkCargadoHermano.attr('disabled', false);
    } else {
        checkCargadoHermano.attr('checked', false);
        checkCargadoHermano.attr('disabled', true);
    }
};

var fnEnviarServer = function (data) {
    $.post($('#url-proyecto').val() + 'bandejasflujos/ajaxSetDatosInfoPaquetesTesoreria', {data: data}, function (data) {
        location.reload();
    }, 'json');
};

var fnGuardar = function () {

    bootbox.confirm("Desea guardar la informacion ingresada?", function (result) {                
        
        if (result) {
                        
            var valido=validarFacturasTesoreria();
            
            if(valido){
            
                var data = [];
                $('input.excel').each(function () {
                    var parent = $(this).parent().parent();
                    var obj = {
                        id: parent.data('infopaqueteid'),
                        paquete_id: parent.data('paqueteid'),
                        incluido_excel_tesoreria: $(this).is(":checked"),
                        cargado_tesoreria_exito: parent.find('input.cargado').first().is(":checked"),
                        flujotesoreria_id: parent.find('#selflujotesoreria').first().val(),
                        banco_id: parent.find('#selbanco').first().val(),
                        txtcscnovasoft: parent.find('#txtcscnovasoft').first().val(),
                        formapago_id: parent.find('#selformapago').first().val()
                    };
                    data.push(obj);
                });

                fnEnviarServer(data);
            }
        }
    });

};



var fnGenerarExcel = function () {

//    var result = confirm("¿Desea generar el archivo para Novasoft?");
    bootbox.confirm("¿Desea generar el archivo para Novasoft?", function (result) {
        if (result) {

            var data = "";
            var primero = true;
            $('input.excel').each(function () {
                var parent = $(this).parent().parent();

                if ($(this).is(":checked")) {
                    var sep = "|";
                    if (primero) {
                        sep = "";
                        primero = false;
                    }
                    data += "" + sep + "" + parent.data('paqueteid');
                }
            });

            if (data.length == 0) {
                bootbox.alert("No ha seleccionado facturas. Seleccione e intente nuevamente.");
            } else {
                var href = $('#url-proyecto').val() + 'bandejasflujos/generarPlanoTesoreria/';
                href = "" + href + "" + data;
                $.fileDownload(href, {
                    successCallback: function (url) {
                        bootbox.alert("Generación exitosa!", function () {
                            location.reload();
                        });
                    },
                    failCallback: function (html, url) {
                        bootbox.alert('La descarga ha fallado para la URL:' + url + '<br>' + html);
                    }
                });
            }
        }
    });

    return false;
};

var fnSeleccionarTodosExcel = function () {
    if ($(this).data('seleccionar') == '1') {
        $('.excel').prop('checked', true);
        $('.cargado').attr('disabled', false);
        $(this).data('seleccionar', '0');
    } else {
        $('.excel').prop('checked', false);
        $('.cargado').prop('checked', false);
        $('.cargado').attr('disabled', true);
        $(this).data('seleccionar', '1');
    }
};

var fnSeleccionarTodosCargado = function () {
    if ($(this).data('seleccionar') == '1') {
        $('.cargado:enabled').prop('checked', true);
        $(this).data('seleccionar', '0');
    } else {
        $('.cargado:enabled').prop('checked', false);
        $(this).data('seleccionar', '1');
    }
};

//////////**************************************************************////////////////////////////



function fnSeleccionarFiltro(date) {
    
    var filterSelect = date.value;
    if (filterSelect == 'centrosCosto') {  
        
        $('.filters').attr("disabled", "disabled");
        $('.filters').val('');
        $('#nomProveedor').val('');
        $('#sugestionProv').hide();
        $('#sugestionFact').hide();
        $('#'+filterSelect).removeAttr("disabled");
        
    } else if (filterSelect == 'proveedor') { 
        
        $('.filters').attr("disabled", "disabled");
        $('.filters').val('');
        $('#nomProveedor').val('');
        $('#sugestionProv').hide();
        $('#sugestionFact').hide();
        $('#'+filterSelect).removeAttr("disabled");
        
    }else if(filterSelect == 'fechaFactura' || filterSelect == 'fechaPago'){
        $('.filters').attr("disabled", "disabled");
        $('.filters').val('');  
        $('#sugestionProv').hide();
        $('#sugestionFact').hide();        
        $('#'+filterSelect).removeAttr("disabled");
        $('#'+filterSelect+'_1').removeAttr("disabled");
    }else {     
        
        $('.filters').attr("disabled", "disabled");
        $('.filters').val('');
        $('#nomProveedor').val('');    
        $('#sugestionProv').hide();
        $('#sugestionFact').hide();
        $('#'+filterSelect).removeAttr("disabled");
    }
};

var fnObtenerProveedor = function() {
    $.ajax({
            url: $('#url-proyecto').val() + 'bandejasflujos/ajaxGetDatosInfoProveedor',
            data: {proveedor: $('#proveedor').val()},
            type: "POST",
            success: function(data) {
                  var proveedor = JSON.parse(data); 

                  var uls = "";
                  for(var i = 0; i<proveedor.length;i++){
                      uls += "<li onclick='seleccionarNit(this.value, "+ proveedor[i].Indicespadredocsvalor.valor +" );' value='" + proveedor[i].Indicespadredocsvalor.documentospaquete_id + "'>" + proveedor[i].Indicespadredocsvalor.valor + "</li>";
                  }
                  
                  $('#sugestionProv').show();
                  $('#sugestionProv').html(uls);
            }
        });
};

function seleccionarNit(idDocumento, nitProv){
    $('#proveedor').val(nitProv);
    $('#sugestionProv').hide();
    
        $.ajax({
            url: $('#url-proyecto').val() + 'bandejasflujos/ajaxGetDatosNomProveedor',
            data: {idDocumento: idDocumento},
            type: "POST",
            success: function(data) {
                  var proveedor = JSON.parse(data); 
                  $('#nomProveedor').val(proveedor[0].Indicespadredocsvalor.valor);                  
            }
        });
}

var fnObtenerFactura = function(){
    $.ajax({
            url: $('#url-proyecto').val() + 'bandejasflujos/ajaxGetDatosInfoFactura',
            data: {factura: $('#factura').val()},
            type: "POST",
            success: function(data) {
                  var factura = JSON.parse(data); 

                  var uls = "";
                  for(var i = 0; i<factura.length;i++){
                      uls += "<li onclick='seleccionarFact(this.value);' value='" + factura[i].Indicespadredocsvalor.valor + "'>" + factura[i].Indicespadredocsvalor.valor + "</li>";
                  }
                  $('#sugestionFact').show();
                  $('#sugestionFact').html(uls);
            }
        });    
};

function seleccionarFact(numFact){
    $('#factura').val(numFact);
    $('#sugestionFact').hide();
}




var fnValidarFechasFacturas = function(){    
    
     if($('#fechaFactura').val()!="" || $('#fechaFactura_1').val() != ""){
        var fecDesde = $('#fechaFactura').val();
        var fecHasta = $('#fechaFactura_1').val();        
    }else if($('#fechaPago').val()!="" || $('#fechaPago_1').val() != ""){
        var fecDesde = $('#fechaPago').val();
        var fecHasta = $('#fechaPago_1').val();         
    }
    
    if(fecDesde ==  "" && fecHasta == ""){
        
    }else{
        var fDesde = new Date();
        var fHasta = new Date();
        var fechaInicial = fecDesde.split("-");
        fDesde.setFullYear(fechaInicial[2],fechaInicial[1]-1,fechaInicial[0]);

        var fechaFinal = fecHasta.split("-");
        fHasta.setFullYear(fechaFinal[2],fechaFinal[1]-1,fechaFinal[0]);

        if (fDesde > fHasta){
            alert('La fecha inicial debe ser menor a la fecha final');
            return false;
        }        
    }            
};


/**
 * Funcion que permite direccionar a la bandeja de tesoreria sin filtros.
 * 
 * @returns {fnListadoTesoreriaSinFiltros}
 */
var fnListadoTesoreriaSinFiltros = function(){
            
    var bandejasflujo_id=$("#bandejasflujo_id").val();           
    var hrefBandeja=$("#li_"+bandejasflujo_id).find("a");
       
    /// se obtiene la url  y se direcciona al usuario a la misma bandeja pero sin filtros
    if(hrefBandeja.length>0){
        
        var linkBandeja=hrefBandeja.get(0).href;
        location.href=linkBandeja; 
    }      
};


$(function () {
    $('.excel').click(fnClickExcel);
    $('#btn_guardar').click(fnGuardar);
//    $('#btn_generar').click(fnGenerarExcel);

    $('#select_all_excel').click(fnSeleccionarTodosExcel);
    $('#select_all_cargado').click(fnSeleccionarTodosCargado);  
    
    $('#proveedor').keyup(fnObtenerProveedor);
    $('#factura').keyup(fnObtenerFactura);

     $('#btn_buscar').click(fnValidarFechasFacturas);
	 
	 $("#btn_limpiar_filtros").click(fnListadoTesoreriaSinFiltros);
    
    agregarDatePickerInput();
});


/////////////*******************
