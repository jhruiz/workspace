<?php
    $this->layout=false;
?>

<script type="text/javascript">

    function cerrarDialogoGnral() {
        $('#trazaPaqModal').modal('hide');
    }

</script>

<div id="trazaPaqModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>Trazabilidad</h3>
    </div>
    <div class="modal-body modal-trazabilidad">      
        <div class="indicesdocpaquete form" id="indicDocPaquete" text-align: center>   

            <h4><?php echo __($nombre_bandeja); ?></h4>
            <br>

                <?php
                    $numIndicesmostrados=0;

                    if(!empty($trazas)){

                ?>
            <table width="80%" class="table table-striped">
                <th width="15%">Fecha</th>
                <th width="15%">Origen</th>
                <th width="15%">Usuario Envia</th>
                <th width="15%">Destino</th>
                <th width="25%">Dias</th>
                <?php

                        foreach($trazas as $k => $traza){
                            $numIndicesmostrados++;

                            echo "<tr>";
                            echo    "<td width='20%'>";
                            echo $traza['Trazabilidade']['created'];
                            echo    "</td>";
                            echo    "<td width='20%'>";
                            echo $traza['Estado']['descripcion'];
                            echo    "</td>";
                            echo    "<td width='20%'>";
                            echo $traza['Usuario']['nombre'];
                            echo    "</td>";
                            echo    "<td width='25%'>";
                            echo $traza['Estadodestino']['descripcion'];
                            echo    "</td>";
                            echo    "<td width='15%'>";
                            echo $traza['Trazabilidade']['diaspromedio'];
                            echo    "</td>";
                            echo "</tr>";
                        }                                
                    }

                    if($numIndicesmostrados>0){
                         echo "</table><br>";
                         echo "<b>Total días: " . $tiempoTotal . "</b>";
                    }else{
                        echo "No hay registros";
                    }
                ?>
                <br>
                <div class="modal-footer">
                    <button class="btn btn-info" onclick="cerrarDialogoGnral()" aria-hidden="true">Cerrar</button>
                </div>
        </div>




