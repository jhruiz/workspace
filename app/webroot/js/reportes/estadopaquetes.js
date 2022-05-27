/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function()
{
});

function obtenerCiudades()
{
    var idregional = $("#ReporteRegional option:selected").val();
    $.ajax({
        type: 'POST',
        url: $('#url-proyecto').val() + 'reportes/obtenerciudades',
        data: {idregional: idregional},
        success: function(data) {
            $("#divCiudades").html(data);
            $("#ReporteCiudad option:selected").val("")
        }
    });
}
function obtenerOficinas()
{
    var idciudad = $("#ReporteCiudad option:selected").val();

    $.ajax({
        type: 'POST',
        url: $('#url-proyecto').val() + 'reportes/obteneroficinas',
        data: {idciudad: idciudad},
        success: function(data) {
            $("#divOficinas").html(data);
        }
    });
}

function obtenerUsuarios()
{
    var idoficina = $("#ReporteOficina option:selected").val();

    $.ajax({
        type: 'POST',
        url: $('#url-proyecto').val() + 'reportes/obtenerusuarios',
        data: {idoficina: idoficina},
        success: function(data) {
            $("#divUsuarios").html(data);
        }
    });
}

function validaReporte(perfil)
{
    var fechaInicio = $("#ReporteFechaInicio").val();
    var fechaFin = $("#ReporteFechaFin").val();
    if (fechaInicio == "" || fechaFin == "")
    {
        alert("El rango de fecha de inicio y fin del reporte es obligatorio. \nAsigne las fechas en los campos Desde y Hasta.");
        return false;
    }   

    if (perfil == "1")
    {
        var usuario = $("#ReporteUsuario option:selected").val();
        if (usuario == "")
        {
            alert("El campo usuario es obligatorio. Debe seleccionar una de las opciones de la lista.");
            return false;
        }
    }

    return true;
}