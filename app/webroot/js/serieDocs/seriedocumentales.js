/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

///Recibe el id de la serie documental y verifica si tiene subseries documentales/
/// por un llamado ajax
function obtenerSubSeriesDocsAjax(seriedoc_id){        
    
    var selectSubSeries="";
    
    if(seriedoc_id !== null && typeof seriedoc_id !== "undefined" && seriedoc_id>0){
                
        $.ajax({
            type: 'POST',
            dataType:'json',
            async: false,
            url: $('#url-proyecto').val()+'seriesdocumentales/obtenersubseriesajax',
            data: {seriedoc: seriedoc_id},
            success: function(data){   
                var datos=eval(data);               
                
                selectSubSeries=datos;              
            }
        });
        
        return selectSubSeries;
        
    }else{
        bootbox.alert("Falta información para obtener las subseries documentales");
    }
}



///Recibe el id de la serie o subserie documental y obtiene sus tipos documentales
/// por un llamado ajax
function obtenerTipoDocsSerieAjax(seriedoc_id,tipo_permiso){        
    
    var selectTipoDoc="";    
    
    if(seriedoc_id !== null && typeof seriedoc_id !== "undefined" && seriedoc_id>0){
                
        $.ajax({
            type: 'POST',
            dataType:'json',
            async: false,
            url: $('#url-proyecto').val()+'seriesdocumentales/obtenertipodocseriepermisoajax',
            data: {seriedoc_id: seriedoc_id, tipo_permiso: tipo_permiso},
            success: function(data){   
                var datos=eval(data);               
                
                selectTipoDoc=datos;              
            }
        });                
        
    }else{
        bootbox.alert("Falta información para obtener los tipos documentales");
    }
    
    return selectTipoDoc;
}


  ///Por medio de un llamado ajax obtiene los campos de los indices de una serie o 
    //subserie documental, tipo_serie indica si es serie o subserie
    function obtenerCamposIndicesSerieDoc(seriedoc_id){                                
        
        var camposIndices="";
        if(seriedoc_id!==null && seriedoc_id!=="" && typeof seriedoc_id!=="udnefined" && seriedoc_id>0){            

            $.ajax({
                url: $('#url-proyecto').val()+"seriesdocumentales/obtenerindicesseriedocajax",
                type: "POST",
                dataType: "json", 
                async: false,
                data: {seriedoc_id: seriedoc_id},
                success: function(data){

                    var datos=eval(data);

                    camposIndices=datos.info;                                 
                }
            });
        }else{
            bootbox.alert("Debe seleccionar una serie/subserie documental valida.");
        }
        
        return camposIndices;
    }
    
    var nuevaSerie = function(){
        window.location.href = $('#url-proyecto').val() + "series/add";
    };

