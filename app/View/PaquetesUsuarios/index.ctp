<?php
$this->layout = 'inicio';
echo ($this->Html->script('paquetesusuarios/gestionpaquetesusuarios.js')); 
$parametrosDetalle=json_encode($paquetesUsuarios);
?>
<div class="paquetesUsuarios index">
    
    <h2><?php echo __('Buscar Oficio'); ?></h2> 
    <?php echo $this->Form->create('PaquetesUsuario',array('action'=>'search','method'=>'post'));?>
            <fieldset>
                    <legend><?php __('PaquetesUsuario Search');?></legend>
                    <table>
                        <tr>
                            <td>
                                <?php echo $this->Form->input('Search.Oficio', array('label' => 'Número de Oficio')); ?>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
            <?php	echo $this->Form->input('accion_anterior', array('type'=>'hidden', 'value'=>'index', 'id'=>'accion_anterior')); ?>
            </fieldset><br>
     <?php echo $this->Form->submit('Buscar',array('class'=>'btn btn-info'));?>
    </form>
    <br/>
    <br/>
    
    <div id="tabs">
        <ul>
            <li id="li_paquetes"><a href="#div_paquetes">Listado</a></li>        
            <li id="li_detalle"><a href="#div_detalles">Detalle</a></li>
        </ul>
        <div id="div_paquetes">
            <h2><?php echo __('Oficios'); ?></h2>
            <?php  if(!empty($paquetesUsuarios)){ ?>
                    <table class="CSSTable">
                        <tr>
                                 <th><?php echo ('Número de Oficio'); ?></th>
                                <th><?php echo ('Usuario Asignado'); ?></th>
                                <th><?php echo ('fecha_asignacion'); ?></th>
                                <th class="actions"><?php echo __('Acciones'); ?></th>
                        </tr>
                        <?php foreach ($paquetesUsuarios as $paquetesUsuario): ?>
                            <tr>
                                <td>
                                        <?php echo h($paquetesUsuario['Paquete']['numero_oficio']); ?>&nbsp;
                                </td>
                                <td>
                                        <?php echo h($paquetesUsuario['Usuario']['nombre']); ?>&nbsp;
                                </td>
                                <td><?php echo h($paquetesUsuario['PaquetesUsuario']['fecha_asignacion']); ?>&nbsp;</td>
                                <td class="actions"> 
                                    <?php  echo $this->Form->button("Ver Detalle", array('id' => 'btnVerDetalle_'.$paquetesUsuario['PaquetesUsuario']['paquete_id'],  'type'=>'button','class'=>'btn btn-info btn_detalle')); ?> 
                                     <?php echo $this->Form->input('infodetalle_'.$paquetesUsuario['PaquetesUsuario']['paquete_id'],
                                                                        array(
                                                                            'id' => 'infodetalle_'.$paquetesUsuario['PaquetesUsuario']['paquete_id'],
                                                                            'type' => 'hidden',                    
                                                                            'value'=> json_encode($paquetesUsuario),                    
                                                                        )); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php
                    ///Hidden para guardar el id del paquete seleccionado para ver su detalle
                    echo $this->Form->input('paqueteseleccionado_id', array(                        
                        'id' => 'paqueteseleccionado_id',
                        'type' => 'hidden',                       
                    ));                    
                    ?>                            
                    </table>
                    <p>
                    <?php
                    echo $this->Paginator->counter(array(
                        'format' => __('Página {:page} de {:pages}, mostrando {:current} registro de {:count} en total, iniciando en registro {:start}, finalizando en {:end}')
                    ));
                    ?>	</p>
                    <div class="paging">
                        <?php
                                echo $this->Paginator->prev('< ' . __('Anterior'), array(), null, array('class' => 'prev disabled'));
                                echo $this->Paginator->numbers(array('separator' => ' | | '));
                                echo $this->Paginator->next(__('Siguiente') . ' >', array(), null, array('class' => 'next disabled'));
                        ?>
                    </div>
            <?php  }else{ ?>
                        <br/>
                            No hay paquetes registrados.
            <?php  } ?>
        </div>
        <div id="div_detalles">Debe seleccionar un paquete en la pestaña 'Listado'.</div>
    </div>
</div>

