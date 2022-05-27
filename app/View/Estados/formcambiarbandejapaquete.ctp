
<style type="text/css">
    label {
            float: left;
            width: 120px;
            display: block;
            clear: left;
            text-align: left;
            cursor: hand;
        }
</style>
<?php

    $this->layout=false;
    
    echo $this->Html->script('estados/formasignaestado.js');
  
    if(isset($permisoTraslado['PrivilegiosUsuario']) && $permisoTraslado['PrivilegiosUsuario']['privilegio_id'] == "3" && isset($arrRelBandEst)){
?>

        <div class="paquetes form" id="divAsignaUsuario" text-align: center>   
            <center>
            <h4><?php echo __('Cambiar Estado del Oficio'); ?></h4>
            <br/>
            <br/>
            <?php echo $this->Form->create(null, array('id' => 'formCambiarEstadoOficio', 'default' => false)); ?>            
            <table width='100%'>
                <tr>
                    <td nowrap>
                        <?php
                            echo $this->Form->input("Estado a asignar:",
                                    array(
                                        'name'=>"estadoasignar",
                                        'id' => "estadoasignar",
                                        'type' => 'select',
                                        'options'=>$arrRelBandEst,
                                        'empty' => 'Seleccione Uno'
                                    )
                            );
                            echo $this->Form->input("paquete_id",
                                    array(                                    
                                        'id' => "paquete_id",
                                        'type' => 'hidden',
                                        'value'=>$paqueteId
                                    )
                            );
                            echo $this->Form->input("paquetesusuario_id",
                                    array(                                    
                                        'id' => "paquetesusuario_id",
                                        'type' => 'hidden',
                                        'value'=>$paquetesusuarioId
                                    )
                            );
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><center><button  id="btn_guardarEst" class="btn btn-info" >Guardar</button></center></td>                    
                </tr>
            </table> 
            </center>
        </form>
        </div>
    <?php } else{ ?>
  
            <div id="error" class="alert alert-success" style="text-align: center">
                <b>La funcionalidad no esta disponible</b>
            </div>   
    <?php } ?>