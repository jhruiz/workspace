/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



///Por medio de un llamado ajax obtiene los campos de los indices de un tipo  documental
    function obtenerCamposIndicesTipoDoc(tipodoc_id){                                
        
        var camposIndices="";
        if(tipodoc_id!==null && tipodoc_id!=="" && typeof tipodoc_id!=="undefined" && tipodoc_id>0){            

            $.ajax({
                url: $('#url-proyecto').val()+"tiposdocumentales/obtenerindicestipodocajax",
                type: "POST",
                async: false,
                dataType: "json",            
                data: {tipodoc_id: tipodoc_id},
                success: function(data){

                    var datos=eval(data);                   
                    
                    camposIndices=datos.info;                                                            
                }
            });
        }else{
            bootbox.alert("Debe seleccionar un tipo documental valido.");
        }
        
        return camposIndices;
    }
    
    var nuevoTipoDoc = function(){
        window.location.href = $('#url-proyecto').val() + "tipodocumentos/add";
    };
