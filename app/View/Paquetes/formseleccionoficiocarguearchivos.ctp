<?php
    $this->layout=false;
    
    echo $this->Html->script('paquetes/indexaciondocumentos.js');
  
    if(!empty($arrSolicitud)){
?>

        <div class="paquetes form" id="divSeleccionoficio" text-align: center>   
            <center>
            <h4><?php echo __('Seleccionar Solicitud'); ?></h4>
            <br/>
            <br/>
            <?php echo $this->Form->create(null, array('id' => 'formSeleccionarOficio', 'default' => false)); ?>            
            <table width='100%' class="table">
                <tr>
                    <th>Número Credencial</th>
                    <th>Número Solicitud</th>                    
                    <th>Fecha Creación</th>
                    <th>Estado</th>
                    <th>&nbsp;</th>
                </tr>   
                <?php foreach ($arrSolicitud as $paquete):?>
                <tr>
                    <td><?php echo h($paquete['Paquete']['numerocredencial']); ?>&nbsp;</td> 
                    <td><?php echo h($paquete['Paquete']['numerosolicitud']); ?>&nbsp;</td>                     
                    <td><?php echo h($paquete['Paquete']['fechacreacion']); ?>&nbsp;</td> 
                    <td><?php echo h($paquete['E']['descripcion']); ?>&nbsp;</td> 
                    <td><input type="radio" name="oficio" id="oficio_<?php echo $paquete['Paquete']['id'];?>" value="<?php echo $paquete['Paquete']['id'];?>" >&nbsp;</td> 
                    <input type="hidden" id="o_<?php echo $paquete['Paquete']['id'];?>" value="<?php echo $paquete['O']['id'];?>">
                    <input type="hidden" id="od_<?php echo $paquete['Paquete']['id'];?>" value="<?php echo $paquete['O']['descripcion'];?>">
                    <input type="hidden" id="c_<?php echo $paquete['Paquete']['id'];?>" value="<?php echo $paquete['C']['id'];?>">
                    <input type="hidden" id="cd_<?php echo $paquete['Paquete']['id'];?>" value="<?php echo $paquete['C']['descripcion'];?>">
                    <input type="hidden" id="r_<?php echo $paquete['Paquete']['id'];?>" value="<?php echo $paquete['R']['id'];?>">
                    <input type="hidden" id="rd_<?php echo $paquete['Paquete']['id'];?>" value="<?php echo $paquete['R']['descripcion'];?>">
                    <input type="hidden" id="s_<?php echo $paquete['Paquete']['id'];?>" value="<?php echo $paquete['Paquete']['numerosolicitud'];?>">
                </tr>
                <?php endforeach;?>
                <tr><td colspan="5"><br><center><button  id="btn_guardarOficio" class="btn btn-info" onclick="obtenerOficioSeleecion();">Cargar Información</button></center><br>
            <?php if($permisoCrearId == '1'){?>
                <center><button id="btn_nuevaSoliciud" class="btn btn-info" onclick="nuevasolicitud('1');">Nueva Solicitud</button></center>
            <?php }?>
                </td></tr>
                    
            </table> 
            </center>
        </form>
        </div>
    <?php } else{ ?>
  
            <div id="error" class="alert alert-success" style="text-align: center">
                <b>La funcionalidad no esta disponible</b>
            </div>   
    <?php } ?>