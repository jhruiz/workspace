/**
 * Funcion para crear un menu padre
 */
var nuevaUbicacion = function(){
    window.location.href = $('#url-proyecto').val() + "ubicacionesfisicas/add";
};


/**
 * Funcion para crear un submenu
 * @param {*} nombre 
 * @param {*} id 
 */
var agregarUbicacion = function(datos){
    var id = $(datos).data('id');
    var nombre = $(datos).data('desc');
    window.location.href = $('#url-proyecto').val() + "ubicacionesfisicas/addsubdir/" + nombre + "/" + id;
};


/**
 * Funcion para desplegar los submenus de un menu padre u ocultarlos
 * @param {*} id 
 */
var gestionSubmenus = function(datos) {
    console.log(datos);

    var id = $(datos).data('idpadre');

    //verifica si el folder está abierto o cerrado
    if($('#folder_' + id).hasClass('open')) {
        $('#folder_' + id).removeClass('open');
        $('#ifolder_' + id).removeClass('fa-folder-open').addClass('fa-folder');

        $('#submenu_' + id).html("");
    } else {
        $('#folder_' + id).addClass('open');
        $('#ifolder_' + id).removeClass('fa-folder').addClass('fa-folder-open');

        $.ajax({
            type: 'POST',
            dataType:'json',
            async: false,
            url: $('#url-proyecto').val() + "ubicacionesfisicas/obtenersubmenus",
            data: {id_menu: id},
            success: function(data){   
                var datos=eval(data);  
                
                generarSubCarpetas(datos, id);             
            }
        });
    }
}

/**
 * Crea las subcarpetas de la carpeta padre seleccionada
 * @param {*} datos 
 * @param {*} idPadre 
 */
var generarSubCarpetas = function(datos, idPadre) {
    //<div class="media-body"></div>

    var ubicacionHtml = "";
    datos.forEach(element => {
        
        var fId = element.Ubicacionesfisica.id;
        var fDesc = element.Ubicacionesfisica.descripcion;

        ubicacionHtml += "<div class='media'>";
        ubicacionHtml += "<div class='pull-left' id='folder_" + fId + "' data-idpadre='" + fId + "' style='cursor: pointer;' onclick='gestionSubmenus(this)'>";
        ubicacionHtml += "<i1 class='fa fa-folder fa-2x' title='Ver' id='ifolder_" + fId + "' style='color:#FFC300'></i></div>";
        ubicacionHtml += "<div class='media-body'>";
        ubicacionHtml += "<h5 class='media-heading'><span style='cursor: pointer;' title='Agregar' data-desc='" + fDesc + "' data-id='" + fId + "' onclick='agregarUbicacion(this)'>" + fDesc + "</span>";
        ubicacionHtml += "<span style='cursor: pointer; margin-left:10px;' title='Editar' data-id='" + fId + "' onclick='editarUbicacion(this)'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></span></h5>";
        ubicacionHtml += "<div id='submenu_" + fId + "'></div>";        
        ubicacionHtml += '</div></div>'

    });

    $('#submenu_' + idPadre).html(ubicacionHtml);
}

/**
 * Redirige al formulario de edición
 * @param {*} datos 
 */
var editarUbicacion = function(datos){

    var id = $(datos).data('id');
    window.location.href = $('#url-proyecto').val() + "ubicacionesfisicas/edit/" + id;

}
