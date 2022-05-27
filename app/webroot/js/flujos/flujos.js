/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


///Por medio de un llamado ajax obtiene los campos del flujo y los ubica en un div
    function obtenerCamposFlujo(flujo_id){
        
        var camposFlujo;
        if(flujo_id!==null && flujo_id!=="" && typeof flujo_id!=="undefined" && flujo_id>0){            

            $.ajax({
                url: $('#url-proyecto').val()+"flujos/obtenercamposflujoajax",
                type: "POST",
                dataType: "json",  
                async: false,
                data: {flujo_id: flujo_id},
                success: function(data){

                    var datos=eval(data);
                    camposFlujo=datos;                                                    
                }
            });
        }else{
            alert("Debe seleccionar un flujo valido.");
        }
        
        return camposFlujo;
    }


