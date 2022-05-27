    $(document).ready(function(){
       $("#btn_trasladoOf").bind("click",function(){  
           setMotivoTraslado();
       });

       $("#btn_cancelarTraslado").bind("click",function(){  
           cancelarTrasladoOficios();
       });    
    });

    function cancelarTrasladoOficios(){
        dialogTraslado.dialog('close');
    }
    
    function setMotivoTraslado(){
            
            var mensaje = "";
            
            var motTraslado = $('#motivostraslado').val();
            mensaje = validarTraslado(motTraslado);
            
            if(mensaje != ""){
                bootbox.alert(mensaje); 
                return;
            }            
            bootbox.confirm("¿Está seguro que desea trasladar la(s) solicitud(es)?", function (result) {
                if (result) {
                    //Se obtiene el usario al cual se le van asignar las solicitudes
                    var usuarioSelect = $('#usrTraslado').val();

                    //Se obtiene el arreglo de solicitudes a trasladar
                    var checkboxValues = new Array();
                    $("input:checkbox:checked").each(function(){
                            checkboxValues.push($(this).val());
                    });

                    var respFinal = true;
                    for(var i = 0; i < checkboxValues.length; i++){

                        var paqUsrId = $('#'+checkboxValues[i]).val();

                        $.post(urlBase+'paquetesusuarios/cambiarpaqueteusuario', {
                            usuario_id : usuarioSelect,
                            paquete_id : checkboxValues[i],
                            paquetesusuarioactual_id : paqUsrId,
                            motivotraslado_id : motTraslado
                        }, function(responseText){
                            var respuesta = JSON.parse(responseText); 
                            respFinal = respuesta.estado;
                            if(respFinal == false){
                                respFinal = false;
                            }
                        });                     
                    }   
                    if(respFinal == true){
                        bootbox.alert('Se realizó la transferencia de forma correcta', function(){
                            $("input:checkbox:checked").each(function(){
                                    $(this).prop('checked', false);
                            });
                            location.reload();
                        });
                    }else{
                        bootbox.alert('Se presentó un error en la transferencia. Por favor, inténtelo de nuevo', function(){
                            location.reload();
                        });
                    }                 
                }
        });
    }
    
    function validarTraslado(motTraslado){
        var mensaje = "";        
        
        if(motTraslado == ""){
            mensaje = 'Debe seleccionar un motivo para el traslado';
        }
        
        return mensaje;
    }