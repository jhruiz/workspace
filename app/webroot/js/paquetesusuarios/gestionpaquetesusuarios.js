/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */




$(document).ready(function(){
    $("#tabs").tabs({
        active: 0,
        disabled: [1],
        hide: { effect: "blind", duration: 1200 },
        show: { effect: "blind", duration: 1200 },
        activate: function(event,ui){                       
            if(ui.newTab.index()==0){
                $("#tabs").tabs("option","disabled",[1]);
            }
        }
    });
    
    $(".btn_detalle").each(function(){
        $(this).bind("click",function(){

            $("#tabs").tabs("option","disabled",false,[1]);
            var idBoton=$(this).prop("id");    
            var splitIdButon=idBoton.split("_");
            ///Se guarda el id del paquete seleccionado
            $("#paqueteseleccionado_id").val(splitIdButon[1]);
            
            cargarDetallePaquete(splitIdButon[1]);    
            
        }); 
    });
    
    
    $("#btn_buscar").bind("click", function(){
         $("#tabs").tabs("option","active",0);
    });       
});

function cargarDetallePaquete(paquete_id){
    
    if(paquete_id!=""){
        var infoDetalle=$("#infodetalle_"+paquete_id).val();     
        $("#div_detalles").load($('#url-proyecto').val() +"PaquetesUsuarios/infopaquete",{paquete_id: paquete_id},function(){
            $("#tabs").tabs("option","active",1);
        });
    }
}






