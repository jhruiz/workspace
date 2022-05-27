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
    
    echo $this->Html->script('paquetesusuarios/formasignausuario.js');
  
    if(!empty($paqueteId) && isset($usuarios)){
?>

        <div class="paquetes form" id="divAsignaUsuario" text-align: center>   
            <center>
            <h4><?php echo __('Cambiar Usuario Encargado de Paquete'); ?></h4>
            <br/>
            <br/>
            <?php echo $this->Form->create(null, array('id' => 'formCambiarUsuPaq', 'default' => false)); ?>            
            <table width='100%'>
                <tr>
                    <td nowrap>
                        <?php                                            
                            echo $this->Form->input("Usuario a asignar:",
                                    array(
                                        'name'=>"usuarioasignar",
                                        'id' => "usuarioasignar",
                                        'type' => 'select',
                                        'options'=>$usuarios,
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
                                        'value'=>$paqueteusuarioId
                                    )
                            );                            
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><center><button  id="btn_guardar" class="btn btn-info" >Guardar</button></center></td>
                    
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