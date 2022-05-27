/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */




function verIndiciesDocPaq(docpaquete_id,idDivIndices){
        
        $.post($('#url-proyecto').val()+'paquetes/verindicesdocpaquete', {
            docpaquete_id : docpaquete_id,            
        }, function(responseText){

                $('#'+idDivIndices).html(responseText);
                $('#indicesDocPaqModal').modal("show");
        });       
    }   

