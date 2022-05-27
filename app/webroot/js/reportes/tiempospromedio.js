/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() 
{
    $('#ReporteAdmision').val("");
    $('#divreferencia').hide();
});

function mostrarCampoAdmision()
{
    var id_opcion = $('#ReporteProceso option:selected').val();
    if(id_opcion === '0')
    {
        $('#ReporteAdmision').val("");
        $('#divreferencia').hide();
    }else
    {
        $('#ReporteAdmision').val("");
        $('#divreferencia').show();
    }
}
