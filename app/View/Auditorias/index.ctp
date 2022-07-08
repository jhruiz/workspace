<?php    
    $this->layout = 'inicio'; 
     echo $this->Html->script('general.js');
?>

<div class="auditorias index">
    <div id="acordion1">
        <h2><?php echo __('Filtros'); ?></h2> 
        <?php echo $this->Form->create('Auditoria',array('action'=>'search','method'=>'post'));?>
                <fieldset>
                        <legend><?php __('Auditorias Search');?></legend>
                        <table>
                            <tr>
                                <td>
                                    <?php echo $this->Form->input('Search.Descripcion'); ?>
                                </td>
                                <td>
                                    <?php echo $this->Form->input('Search.Accion'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                   <?php echo $this->Form->input('Search.FechaDesde',array('label' => 'Desde', 'type'=>'text',  'id'=>'fecha_desde')); ?>
                                </td>
                                <td>
                                    <?php echo $this->Form->input('Search.FechaHasta',array('label' => 'Hasta', 'type'=>'text',  'id'=>'fecha_hasta')); ?>
                                </td>
                            </tr>
                        </table>
                <?php	echo $this->Form->input('accion_anterior', array('type'=>'hidden', 'value'=>'index', 'id'=>'accion_anterior')); ?>
                </fieldset><br>
         <?php echo $this->Form->submit('Buscar',array('class'=>'btn btn-info'));?>
        </form>        
        </div><br>

	<h2><?php echo __('Auditorías'); ?></h2>
	<table class="table table-striped">
	<tr>			
            <th><?php echo ('Usuario'); ?></th>
            <th><?php echo ('Descripción'); ?></th>
            <th><?php echo ('Acción'); ?></th>
            <th><?php echo ('Fecha'); ?></th>
	</tr>
	<?php foreach ($auditorias as $auditoria): ?>
	<tr>		
            <td>
                    <?php echo $this->Html->link($auditoria['Usuario']['nombre'], array('controller' => 'usuarios', 'action' => 'view', $auditoria['Usuario']['id'])); ?>
            </td>
            <td><?php echo h($auditoria['Auditoria']['descripcion']); ?>&nbsp;</td>
            <td><?php echo h($auditoria['Auditoria']['accion']); ?>&nbsp;</td>
            <td><?php echo h($auditoria['Auditoria']['created']); ?>&nbsp;</td>
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
</div>
