/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function cargarSeriesDocs(){    
    
    $.ajax({
            type: 'POST',
            url:'guardar',
            data:{codigo: $('#codigo').val(), nombre:$('#nombre').val()},
            success:function(data){
               
                    $("#indexSeriedocs").html(data);
            }
    });
}
