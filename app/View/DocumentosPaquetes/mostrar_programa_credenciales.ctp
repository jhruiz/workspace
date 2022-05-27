
<?php
$this->layout=false;
echo ($this->Html->script('paquetes/indexaciondocumentos.js')); 
?>
<script type="text/javascript">

    function cerrarDialogoGnral() {
        $('#trazaPaqModal').modal('hide');
    }
    
</script>

<div id="trazaPaqModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>Credenciales</h3>
    </div>
    <div class="modal-body modal-trazabilidad">      
        <div class="indicesdocpaquete form" id="indicDocPaquete" style="text-align: center">   
            <br>
            <?php

            if($response['errorBean']['codigo'] == 0){
                $res = json_encode($response);
                //Setiamos la respuesta del WS para consultarle las credenciales dependiendo del plan.
                echo $this->Form->input('responseWS', array('type' => 'hidden' , 'value' => $res));
                $programas;
                $credencialesObject = $response['credencialesDTO'];
                for ($i=0; $i < count($credencialesObject); $i++) { 
                    $programas[$i] = $credencialesObject[$i]['programa'];
                }
                /*print_r($programas);
                exit;*/
                ?><div class="form-group"><?php
                echo $this->Form->select('Programa:',$programas,
                    array(
                        'name'=>'progama',
                        'id' => 'programa',
                        'class' => 'input-group',
                        'empty' => 'Seleccione uno',
                        'onchange' => "checkForOther(this)"
                    ));
                ?></div>
                <div class="form-group">
                    <?php
                    echo $this->Form->select('Credencial:','',
                        array(
                            'name' => 'credencial' , 
                            'id' => 'credencial' , 
                            'class' => 'input-group',
                            'empty' => 'Seleccione uno'
                        ));
                    ?>
                </div>
                <br>
                <button class="btn btn-info" id="guardar" onclick="validarSolicitud()" aria-hidden="true">Guardar</button>
                <?php            
            }else{
                ?> <p>No existen credenciales para el numero de cedula ingresado</p> <?php
            }$options = array('M' => 'Male', 'F' => 'Female');
            ?>
            <br><br>
            <div class="modal-footer">
                <button class="btn btn-info" onclick="cerrarDialogoGnral()" aria-hidden="true">Cerrar</button>
            </div>
        </div>