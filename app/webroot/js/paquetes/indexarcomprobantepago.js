



/**
 * Agrega los eventos a los campos para cargar los paquetes,
 * @param {type} consecutivo: consecutivo que forma el id de los campos
 * @returns {undefined}
 */
function agregarEventosElem(consecutivo){
    
    $("#selflujo_"+consecutivo).change(cargarConsecutivosTipoPaqueteCompPag);   
    $("#identif_"+consecutivo).blur(cargarConsecutivosTipoPaqueteCompPag); 
    $("#seltipopaquete_"+consecutivo).change(cargarConsecutivosTipoPaqueteCompPag); 
}


/*
 * Permite cargar el archivo a indexar de manera temporal y generar el archivo 
 * djvu, para luego poderlo visualizar
 */
function cargarArchivoIndexacionTmp() {

    cargarArchivoTmp("archivoindexar",$("#iddocindexarform").val(),'butVistaPrevia','butCargarArchivo','urltmppaquete','extensionArchivo','input_file_index');    
}



/*
 * Funcion que realiza un llamado ajax, y permita visualizar el documento djvu dada la url del
 * archivo a visualizar 
 *
 */
function verDocumentoComprobante() {

    var url = $("#urltmppaquete").val();

    verDocumentodjvu(url,'verDocumento2',null,null,false);   
}


/*
 *Funcion llamada al seleccionar un archivo a indexar en el campo input file. Al seleccionar
 *un nuevo archivo, se habilita el boton de cargar y se oculta el de vista previa.     
 */
function seleccionaArchivoIndex() {
    
    $("#urltmppaquete").val("");
    deshabilitarElemento('butVistaPrevia', true);
    deshabilitarElemento('butCargarArchivo', false);
}


function validarFormComprobPago(){        
        
    
    if($("#urltmppaquete").val()==null || typeof $("#urltmppaquete").val()==="undefined" ||  $("#urltmppaquete").val()=="" ){
        bootbox.alert("Debe seleccionar y cargar un archivo.");
        return false;
    }
       
     var facturaCheck=false;  
     
     $(".cls_chckcomppago").each(function(){         
         if($(this).is(":checked")){
             facturaCheck=true;
             return false;
         }
     });
       
       ///Verificar si se ha seleccionado alguna factura
      if(!facturaCheck){
          bootbox.alert("Debe seleccionar una factura para asociar al comprobante de pago.");
          return false;
      }
       
      var confirmacion=confirm("Desea cargar y asociar a los paquetes seleccionados el compobante de pago?");
    
        if(!confirmacion){
            return false;
        }
       
    return facturaCheck;
}

/**
 * Funcion para seleccionar/deseleccionar todass las facturas
 * 
 * @returns {undefined}
 */
function seleccionarTodasFacturas(){
    
    var chck_todos=$("#chckbox_todos").is(":checked");
    
    $(".cls_chckcomppago").each(function(){ 
        
        if(chck_todos){        
            $(this).prop("checked","checked");
        }else{
            $(this).removeAttr("checked");
        }
     });
}



$(document).ready(function () {
    
    $("#formarchivoindex")[0].reset();
    
    
    $("#chckbox_todos").click(seleccionarTodasFacturas);
//    $('#butAgregarPaq').bind("click",copyFirstIndiceTemplate);
    
    $("#butCargarArchivo").bind("click", function () {
        cargarArchivoIndexacionTmp();
    });
    
    $("#archivoindexar").bind("change", function () {
        seleccionaArchivoIndex();
    });
    
    $("#butVistaPrevia").bind("click", function () {
        verDocumentoComprobante();
    });

});

