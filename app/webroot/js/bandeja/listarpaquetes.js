    function obtenerCiudades(){
        var options = $("#RegionaleId option:selected" ).val();
                $.ajax({
                    type: 'POST',
                    async: false,
                    url: $('#url-proyecto').val() + 'usuarios/obtenerciudades',
                    data: {opcion: options},
                    success: function(data){
                        $("#divCiudades").html(data);
                        obteneroficinas();
                    }
                });
                
    }
    
    function obteneroficinas(){  

        var options = $("#CiudadeId option:selected" ).val();
        var obtenerUsuarios=0;
        
        $.ajax({
            type: 'POST',
            async: false,
            url: $('#url-proyecto').val() + 'usuarios/obteneroficinas',
            data: {opcion: options, obtenerUsuarios: obtenerUsuarios},
            success: function(data){  
                $("#divOficinas").html(data);
            }
        });
    }
    
    $(document).ready(function() {
        $("#mostrarZona1").attr('checked', true);
        obtenerCiudades();
    });    


    function focusDate(){
        $("#ui-datepicker-div").hover(
            function() {
                $("#pestana_filtro").css({
                    'right': 0, 
                    'background-color': 'transparent'
                });
            }             
        );

        $("#pestana_filtro").hover(
            function() {
                $("#pestana_filtro").css({
                    'right': 0, 
                    'background-color': 'transparent',
                    "-webkit-transition": "right 0.3s",
                    "transition": "right 0.3s"
                });
            },function() {
                $("#pestana_filtro").css({
                    "right": "-380px",
                    "background-color":"rgba(148, 27, 124, 0.8)",
                    "-webkit-transition": "right 0.3s",
                    "transition": "right 0.3s",
                    "-webkit-transition": "background-color 0.3s",
                    "transition": "background-color 0.3s"
                });
                $("#pestana_filtro").hover();
            } 
        );
    };

    function focusFilter(){
        $("#pestana_filtro").hover(
            function() {
                $("#pestana_filtro").css({
                    'right': 0, 
                    'background-color': 'transparent',
                    "-webkit-transition": "right 0.3s",
                    "transition": "right 0.3s"
                });
            },function() {
                $("#pestana_filtro").css({
                    "right": "-380px",
                    "background-color":"rgba(148, 27, 124, 0.8)",
                    "-webkit-transition": "right 0.3s",
                    "transition": "right 0.3s",
                    "-webkit-transition": "background-color 0.3s",
                    "transition": "background-color 0.3s"
                });
                $("#pestana_filtro").hover();
            } 
        );
    };
