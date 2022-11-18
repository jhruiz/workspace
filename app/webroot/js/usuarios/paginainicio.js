/**
 * Obtiene los labels del gráfico
 * @returns 
 */
 var obtenerLabels = function(data){

    const labels = [];

    data.forEach(element => {
        labels.push(element.E.descripcion);
    });

    return labels;
}

/**
 * Obtiene la cantidad de los datos
 * @returns 
 */
var obtenerData = function(data){
    const datos = [];

    data.forEach(element => {
        datos.push(element['0'].cantidad);
    });

    return datos;
}

/**
 * Generador de colores para el gráfico
 * @returns 
 */
var obtenerBkColors = function() {
    var bkColors = [
        'rgba(255, 99, 132, 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(255, 205, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(153, 102, 255, 0.2)',
        'rgba(201, 203, 207, 0.2)', 'rgba(51, 0, 102, 0.2)', 'rgba(51, 102, 102, 0.2)',
        'rgba(153, 51, 102, 0.2)', 'rgba(255, 102, 102, 0.2)', 'rgba(153, 0, 153, 0.2)',
        'rgba(0, 51, 255, 0.2)', 'rgba(204, 153, 51, 0.2)', 'rgba(156, 39, 176, 0.2)',
        'rgba(96, 125, 139, 0.2)'
      ];

    return bkColors; 
}

/**
 * Obtiene un arreglo con los colores de los bordes para las barras
 * @returns 
 */
var obtenerBrdColors = function() {
    var brdColors = [
        'rgb(255, 99, 132)', 'rgb(255, 159, 64)', 'rgb(255, 205, 86)',
        'rgb(75, 192, 192)', 'rgb(54, 162, 235)', 'rgb(153, 102, 255)',
        'rgb(201, 203, 207)', 'rgba(51, 0, 102)', 'rgba(51, 102, 102)',
        'rgba(153, 51, 102)', 'rgba(255, 102, 102)', 'rgba(153, 0, 153)',
        'rgba(0, 51, 255)', 'rgba(204, 153, 51)', 'rgba(156, 39, 176)',
        'rgba(96, 125, 139)'
      ];

      return brdColors;
}


$(function(){   



    $.post($('#url-proyecto').val()+'paquetes_usuarios/obtenerpaquetesusuario',
    function(responseText){
        var respuesta = JSON.parse(responseText);
        if(respuesta.resp){

            const data = {
                labels: obtenerLabels(respuesta.data),
                datasets: [{
                    label: 'SOLICITUDES POR PROCESAR',
                    data: obtenerData(respuesta.data),
                    backgroundColor: obtenerBkColors(),
                    borderColor: obtenerBrdColors(),
                    borderWidth: 1
                }]
            };
        
            const ctx = document.getElementById('contarBandejas');
        
            new Chart(ctx, {
              type: 'bar',
              data: data,
              options: {
                scales: {
                  y: {
                    beginAtZero: true
                  }
                }
              }
            });

        }
    });    


        
});

