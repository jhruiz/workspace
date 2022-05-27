/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



/*
 * Funcion que obtiene mediante ajax, los paquetes creados de un tipo de paquete para una cabecera
 * @returns {undefined}
 */
function cargarConsecutivosTipoPaquete(flujo, identificador,tipoPaquete) {   

    var informacion="";

    if (identificador != null && typeof identificador !== "undefined" && identificador != "" &&
//            tipoPaquete != null && typeof tipoPaquete !== "undefined" && tipoPaquete != "" &&
            flujo != null && typeof flujo !== "undefined" && flujo != "") {
        $.ajax({
            url: $('#url-proyecto').val() + "cabecerapaquetes/cargartipospaquetescabeceraajax",
            data: {identificador: identificador, flujo: flujo, tipoPaquete: tipoPaquete},            
            dataType: "json",
            type: "POST",
            async: false,
            success: function (data) {

                var datos = eval(data);
                informacion=datos.info;
//                $("#div_paquetecabecera").html(datos.info);
            }
        });
    }
    
    return informacion;
}



/*
 * Funcion que obtiene mediante ajax, las facturas de los paquetes de  una cabecera
 * @returns {undefined}
 */
function cargarFacturasDeCabecera(flujo, identificador,tipoPaquete) {   

    var informacion="";

    if (identificador != null && typeof identificador !== "undefined" && identificador != "" &&                 
            flujo != null && typeof flujo !== "undefined" && flujo != "") {
        $.ajax({
            url: $('#url-proyecto').val() + "cabecerapaquetes/obtenerfacturascabeceraajax",
            data: {identificador: identificador, flujo: flujo, tipoPaquete: tipoPaquete},            
            dataType: "json",
            type: "POST",
            async: false,
            success: function (data) {

                var datos = eval(data);
                informacion={estado: datos.estado ,info: datos.info};
            }
        });
    }
    
    return informacion;
}

