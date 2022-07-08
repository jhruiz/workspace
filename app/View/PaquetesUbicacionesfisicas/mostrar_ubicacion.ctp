<?php
    $this->layout=false;
?>

<script type="text/javascript">
    function cerrarDialogoGnral() {
        $('#modelUbicacionPq').modal('hide');
    }
</script>

<div id="modelUbicacionPq" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>Ubicación</h3>
    </div>

    <div class="modal-body">

        <div style="text-align: center;">    
            <!-- Select padre -->
            <select name="selectPadre" id="selectPadre" onchange="obtenerHijos(this);">
                <option value="">Seleccione una..</option>

                <?php foreach($ubPadre as $up) { ?>
                    <option value="<?php echo($up['Ubicacionesfisica']['id']); ?>"><?php echo ($up['Ubicacionesfisica']['descripcion']); ?></option>
                <?php } ?>

            </select>

            <div id="selectPadre_hijos" class="opcHijos"></div>
        </div>

    </div>

    <div class="modal-footer">
        <button class="btn btn-info" onclick="guardarUbicacion()" aria-hidden="true">Guardar</button>
        <button class="btn btn-info" onclick="cerrarDialogoGnral()" aria-hidden="true">Cerrar</button>
    </div>

</div>




