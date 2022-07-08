<?php
    $url_app = Router::url( '/', true );
    $this->layout='inicio';
    echo $this->Html->script('general.js'); 
    echo ($this->Html->script('bandeja/listarpaquetes.js')); 
	echo ($this->Html->script('trazabilidades/trazabilidad.js')); 
    
    if(isset($permisoUsuarioBandeja) && $permisoUsuarioBandeja != 1){
        $style_gestionar = "style='display: none'";
        $style_ver = "";
    }else{
        $style_gestionar = "";
        $style_ver = "style='display: none'";
    }  
?>
<div id="pestana_filtro">
    <div class="paquetes form" id="divConfigPaquete" text-align: center> 
        <h3><?php echo __('Filtros'); ?></h3> 
        <?php echo $this->Form->create('Bandejas',array('action'=>'searchListarPaquetes','method'=>'post', 'autocomplete'=>'off'));?>
            <fieldset>
                <h4>Credencial</h4>
                <div id='credencial'>
                    <?php echo $this->Form->input('Search.Numero', array('label' => 'Número paquete', 'onclick' => 'focusFilter()', 'autocomplete' => 'off')); ?>                                   
                    <?php echo $this->Form->input('Bandeja', array('type' => 'hidden', 'value' => $_SERVER['REQUEST_URI'])); ?>
                </div>
                <h4>Fecha Creación</h4>
                <div id='fecha'>
                    <?php echo $this->Form->input('Search.FechaDesde',array('label' => 'Desde', 'class' => 'date', 'id'=>'fecha_desde', 'onclick' => 'focusDate()')); ?>
                    <?php echo $this->Form->input('Search.FechaHasta',array('label' => 'Hasta', 'class' => 'date', 'id'=>'fecha_hasta', 'onclick' => 'focusDate()')); ?>
                
                </div>
                <h4>Ubicación</h4>
                <div id="selectReg">
                        <?php
                            echo $this->Form->input('Regionale.id',
                                array(
                                    'type' => 'select',
                                    'label' => 'Regionales:',
                                    'options'=>$arrRegionales,
                                    'onChange'=>'obtenerCiudades()',
                                    'format' => array('label','input', 'after', 'error')
                                )
                            );  
                        ?>  
                </div>
                <div id="selectCiu">
                    <div id='divCiudades'></div>                        
                </div>    
                <div id="selectOfi">
                    <div id='divOficinas'></div>
                </div>
                <?php echo $this->Form->input('accion_anterior', array('type'=>'hidden', 'value'=>'listarpaquetes', 'id'=>'accion_anterior')); ?>
            </fieldset><br>
         <?php echo $this->Form->submit('Buscar',array('class'=>'btn btn-info'));?>
     </div>
    </form>
 </div>
<div id="listaPaquetes">
    <strong><h4><?php echo __($arrInfoBandeja['Bandeja']['descripcion']); ?></h4></strong>
    
    <?php
        if(!empty($arrPaquetes)){
    ?>
        <fieldset>            
            <table class="table table-striped" width='100%'>
            <tr>                                 
                            <?php if(isset($arrPaquetes[0]['Paquete']['color_semaforo']) && $arrPaquetes[0]['Paquete']['color_semaforo'] != ""){?>
                            <th>Semáforo</th>
                            <?php } ?>
                            <th>Fecha</th>
                            <th>Consecutivo</th>
                            <th>Número</th>
                            <th>Región</th>
                            <th>ciudad</th>
                            <th>Oficina</th>
                            <th class="actions"><?php echo __('Acción'); ?></th>
            </tr>
            <?php if (isset($arrPaquetes)){?>
                <?php foreach ($arrPaquetes as $key => $valor):?>
                    <?php echo $this->Form->create(null, array( 'url' => array('controller' => 'bandejas','action'=>'gestionpaquete')));?>
                        <tr>    
                            <input type="hidden" name="permisobandejaId" id="permisobandejaId" value="<?php echo $permisoUsuarioBandeja; ?>">
                            <input type="hidden" name="paqueteId" id="paqueteId" value="<?php echo $valor['Paquete']['id']; ?>">
                            <input type="hidden" name="fechaCreacion" id="fechaCreacion" value="<?php echo $valor['Paquete']['fechacreacion']; ?>">
                            <input type="hidden" name="numeroSolicitud" id="numeroSolicitud" value="<?php echo $valor['Paquete']['numerosolicitud']; ?>">
                            <input type="hidden" name="numeroCredencial" id="numeroCredencial" value="<?php echo $valor['Paquete']['numerocredencial']; ?>">
                            <input type="hidden" name="estado" id="estado" value="<?php echo $valor['Estado']['descripcion']; ?>">
                            <input type="hidden" name="estadoId" id="estado" value="<?php echo $valor['Estado']['id']; ?>">
                            <input type="hidden" name="oficina" id="oficina" value="<?php echo $valor['Oficina']['descripcion']; ?>">                            
                            <input type="hidden" name="oficinaId" id="oficinaId" value="<?php echo $valor['Oficina']['id']; ?>">                            
                            <input type="hidden" name="bandejaId" id="bandejaId" value="<?php echo $bandejaId; ?>">                                                                              
                            
                            <?php if(isset($arrPaquetes[0]['Paquete']['color_semaforo']) && $arrPaquetes[0]['Paquete']['color_semaforo'] != ""){?>
                            <td style="background-color:#ffffff"><center><div style="border-width: 4px; border-radius: 25px; width: 20px;  background: #<?php 
                                            if(isset($valor['Paquete']['color_semaforo'])){
                                                echo $valor['Paquete']['color_semaforo'];
                                            }                                       
                                        ?>; "><?php echo $valor['Paquete']['dias_semaforo']; ?></div></center></td>                                 
                            <?php } ?>

                            <td style="background-color:#ffffff"><?php echo h($valor['Paquete']['fechacreacion']); ?>&nbsp;</td>
                            <td style="background-color:#ffffff"><?php echo h($valor['Paquete']['numerosolicitud']); ?>&nbsp;</td>
                            <td style="background-color:#ffffff"><?php echo h($valor['Paquete']['numerocredencial']); ?>&nbsp;</td>
                            <td style="background-color:#ffffff"><?php echo h($valor['Paquete']['regional']); ?>&nbsp;</td>
                            <td style="background-color:#ffffff"><?php echo h($valor['Paquete']['ciudad']); ?>&nbsp;</td>
                            <td style="background-color:#ffffff"><?php echo h($valor['Oficina']['descripcion']); ?>&nbsp;</td>                            
                            <td style="background-color:#ffffff" class="actions">                                                
                                <input type="submit" name="accion" id="ver" value="Ver" class='btn btn-info' <?php echo $style_ver ?>>  
                                <input type="submit" name="accion" id="gestionar" value="Gestionar" class='btn btn-info' <?php echo $style_gestionar ?>>                              
                                <button type="button" name="butVerTraza" id="butVerTraza" class="btn btn-info" onclick="mostrarTrazabilidad(<?php echo $valor['Paquete']['id']; ?>,'<?php echo __($valor['Estado']['descripcion']); ?>','div_trazabilidad');">Trazabilidad</button><br>
                            </td>
                        </tr>                        
                    </form>
                <?php endforeach; ?>
</table>                  
        <?php }?>  
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('Anterior  '), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('  Siguiente') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>            
        </fieldset> 
    <?php
        }else{
    ?>
            <div id="error" class="alert alert-success" style="text-align: center">
                <b>Sin registros</b>
            </div>            
    <?php
        }
    ?>    
</div>
<div id="div_trazabilidad"></div>

