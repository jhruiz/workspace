/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var opcDialogObservacionDevOf = {
        autoOpen: false,
        modal: true,
        width: 900,
        height: 600,
        position: [400, 10],
        show: {
            effect: "blind",
            duration: 1000
        },
        hide: function () {
        },
        close: function( event, ui){
            $('#obsDevOfi').val("");            
            $('#enviar').attr("disabled", "true");
            $(".radio_bandSec").each(function(){
               $(this).prop('checked', false);
            });            
        },
        title: 'Observación Gestión de la Solicitud'    
};

var dialogObservacionDevOf;    



    /**
     * Valida si el paquete se va a aprobar, rechazar, anular, etc.
     * @returns {undefined}
     */    
    
    function validarTipoGestion(){
            var valueBandSel;

            ///Se obtiene el valor de la bandeja seleccionada para enviar el paquete
            $(".radio_bandSec").each(function(){
                if($(this).is(":checked")){
                    valueBandSel=$(this).val();
                }
            });

            if(validaEstadoRechazo(valueBandSel)){

                $("#div_obsDevOficio").load(
                        $('#url-proyecto').val() + "bandejas/formObservacionesDevOficio",
                        {
                            estadoId : valueBandSel
                        },
                        function(){ 
                            dialogObservacionDevOf = $("#div_obsDevOficio").dialog(opcDialogObservacionDevOf);
                            dialogObservacionDevOf.dialog('open');                                    
                        });                           
            }  
            else{
                guardarPaquete();
            }
    }


    /**
     * Se valida que se cumplan todas las condiciones para realizar la gestion del paquete
     * 
     * @returns {Boolean|undefined}
     */
    function validaGestionPaquete(){

        var valido=true;

            if($("#paqueteId").length <= 0 || $("#paqueteId").val() == null || $("#paqueteId").val() == "" || $("#paqueteId").val() < 0){
                valido=false;
                bootbox.alert("Debe seleccionar un oficio para gestionar.");
            }   

                if(valido){
                    valido=false;
                    //Se verifica que se haya seleccionado al menos una bandeja a enviar            
                    if($(".radio_bandSec").length>0){
                        $(".radio_bandSec").each(function(){
                            if($(this).is(":checked")){
                                valido=true;
                                return false;
                            }
                    });
                } 
                
                if(!valido){
                    bootbox.alert("Debe seleccionar la bandeja a la cual se enviará el oficio.");                
                }else{                    
                    validarTipoGestion();
                }
            }else{
                $('#enviar').attr("disabled", "true");
                $(".radio_bandSec").each(function(){
                   $(this).prop('checked', false);
                });                
            }
    }

    function validarGuardarInformacion(){
        var valido=true;
        
        if($("#paqueteId").length<=0 || $("#paqueteId").val()==null || $("#paqueteId").val()=="" || $("#paqueteId").val()<0){
            valido=false;
            bootbox.alert("Debe seleccionar un oficio para gestionar.");
        }   
        
        if($("#BandejaNumeroOficio").length<=0 || $("#BandejaNumeroOficio").val()==null || $("#BandejaNumeroOficio").val()=="" || $("#BandejaNumeroOficio").val()<0){
            valido=false;
            bootbox.alert("El campo Oficio no puede estar vacio");
        }
        
        if(typeof $("#BandejaFechaRecepcion").val() == 'undefined'){
            valido = true;
        }else if ($("#BandejaFechaRecepcion").length<=0 || $("#BandejaFechaRecepcion").val()==null || $("#BandejaFechaRecepcion").val()==""){
            bootbox.alert("Debe seleccionar una fecha de recepción del oficio."); 
            valido = false;
        }
        
        return valido;
    }
        
    /**
     * Funcion que direcciona al usuario al listado de la bandeja definida por bandejasflujo_id
     * @returns {undefined}
     */
    var fnRedireccionarBandeja=function(){                
        
        var bandejasflujo_id=$("#bandejasflujo_id").val();        
        var url_bandeja="";
        
        ///Se obtiene la url de la bandeja a la cual se debe direccionar        
        url_bandeja=$("#li_"+bandejasflujo_id+" a").first().prop("href");
        
        location.href=url_bandeja;
    };    
    
    var fnGestionarPaquete=function(){
        
        bootbox.confirm("¿Está seguro que desea gestionar la solicitud", function (result) {
             
             if(result){
                 //Se valida el formulario para guardar la getion
                validaGestionPaquete();

             }
         });
    };
    
    /**
     * Funcion que verifica si la proxima bandeja requiere o no asignacion manual de usuario
     * 
     * @param {type} bandejaflujo_id
     * @returns {undefined}
     */
    function verificarAsignaManualProxBandeja(){
        ///Se habilita el boton de enviar
        $('#enviar').removeAttr("disabled");  
    };
        

    $(function(){      
        
        ///agregar evento cuando selecciona la bandeja a enviar
        $(".radio_bandSec").bind("change",function(){
            verificarAsignaManualProxBandeja();
        });        

        $("#enviar").click(fnGestionarPaquete);
        
        ///Se agrega los formatos a los campos de tipo precio y fecha
       agregarClaseCamposRequeridos();
       agregarFormatoNumeros();
       agregarDatePickerInput();
       agregarFormatoNumerico();
    });
        
        
    function validaEstadoRechazo(valueBandSel){

        var valido=false;
        
        $.ajax({
            url: $('#url-proyecto').val() + "estados/validaestadorechazo",
            data:{estadoId: valueBandSel},
            dataType:"json",
            type:"post",
            async: false,
            success:function(data){
                var datos = eval(data);
                if(!datos.valido){
                    valido=false;
                }else{
                    valido=true;
                }
            }
        });
        return valido;        
    }
    
   function guardarPaquete(){
        $('#form_gestionar').submit(); 
   }
   
   function cargarDocumentos(paqueteId){
       window.location.href = $('#url-proyecto').val() + "documentospaquetes/carguearchivos/" + paqueteId;    
   }
   
   function actualizarCredencial(){
       var resp = true;
       
       /*Se valida que el numero de credencial no esté vacio*/
       var numeroCredencial = $('#numeroCredencial').val();
       var numCredencialAct = $('#numCredencial').val();
       var paqueteId = $('#paqueteId').val();
       
       if(numeroCredencial == ""){
           resp = false;
           bootbox.alert("Debe ingresar un número de credencial.");
           
       }
       
       if(resp && numeroCredencial != numCredencialAct){
           $.ajax({
                url: $('#url-proyecto').val() + "paquetes/cambiarNumeroCredencial",
                data:{numeroCredencial: numeroCredencial, paqueteId: paqueteId, numCredencialAct: numCredencialAct},
                dataType:"json",
                type:"post",
                success:function(data){
                    var datos = eval(data);
                    if(!datos.valido){
                        bootbox.alert('No se ha podido cambiar el número de credencial. Por favor, inténtelo de nuevo');
                    }else{
                        bootbox.alert('Se ha actualizado el número de credencial');
                    }
                }
            });           
       }
    
   }            
