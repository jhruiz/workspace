<?php
    $this->layout='inicio';
    echo $this->Html->script('oficinas/oficinas.js');
?>

<div class="oficinas index">
    <div id="acordion1">
    <h2><?php echo __('Filtros'); ?></h2> 
    <?php echo $this->Form->create('Oficina',array('action'=>'search','method'=>'post'));?>
            <fieldset>
                    <table>
                        <tr>
                            <td>
                                <?php echo $this->Form->input('Search.Nombre'); ?>
                            </td>
                            <td>&nbsp;</td>
                            <td>                                
                                <?php  echo $this->Form->input('Search.ciudade_id',
                                        array(
                                            'type' => 'select',
                                            'label' => 'Ciudad',
                                            'options' => $listCiudades,
                                            'empty' => 'SELECCIONE UNO...'
                                        )
                                    );  
                                ?>
                            </td>
                        </tr>
                    </table>
            <?php	echo $this->Form->input('accion_anterior', array('type'=>'hidden', 'value'=>'index', 'id'=>'accion_anterior')); ?>
            </fieldset><br>
     <?php echo $this->Form->submit('Buscar',array('class'=>'btn btn-info'));?>
    </form>
    </div>
    <br/>
        
        <div class="container">
            <div class="left">
                <h2><?php echo __('Oficinas'); ?></h2>
            </div>
            <div class="right">
                <button type="button" class="btn btn-primary" onclick="nuevaOficina()">Nueva Oficina</button>
            </div>
        </div>              
        <?php             
            if(!empty($oficinas)){                
        ?>        
                <table class="table table-striped">
                <tr>
                                <th><?php echo $this->Paginator->sort('descripcion', 'Nombre'); ?></th>
                                <th><?php echo $this->Paginator->sort('ciudade_id','Ciudad'); ?></th>
                                <th class="actions"><?php echo __('Acciones'); ?></th>
                </tr>
                <?php foreach ($oficinas as $oficina): ?>
                <tr>
                        <td><?php echo h($oficina['Oficina']['descripcion']); ?>&nbsp;</td>
                        <td>
                                <?php echo $this->Html->link($oficina['Ciudade']['descripcion'], array('controller' => 'ciudades', 'action' => 'view', $oficina['Ciudade']['id'])); ?>
                        </td>
                        <td class="actions">
                                <?php echo $this->Html->link(__('Ver'), array('action' => 'view', $oficina['Oficina']['id'])); ?>
                                <?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $oficina['Oficina']['id'])); ?>
                                <?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $oficina['Oficina']['id']), null, __('Esta seguro que desea eliminar la oficina %s?', $oficina['Oficina']['descripcion'])); ?>
                        </td>
                </tr>
        <?php endforeach; ?>
                </table>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('Anterior'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('Siguiente') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
                
       <?php
        
        }else{
                echo "No hay oficinas registradas en el sistema.";
            }
        ?>
</div>
