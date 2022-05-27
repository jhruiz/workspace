<?php
    $this->layout='inicio';
?>
<div class="estadoregistros index">
	<h2><?php echo __('Buscar Estado de Registros'); ?></h2>
        
         <?php echo $this->Form->create('Estadoregistro',array('action'=>'search'));?>
                <fieldset>
                        <legend><?php __('Estado_registro Search');?></legend>
                <?php			
                        echo $this->Form->input('Search.Nombre');
                        echo $this->Form->input('accion_anterior', array('type'=>'hidden', 'value'=>'index', 'id'=>'accion_anterior'));
                       
                ?>
                </fieldset>
        <?php echo $this->Form->submit('Buscar',array('class'=>'btn btn-info'));?>
        </form>
        <br>
        
        <legend><h2><?php echo __('Estado Registro'); ?></h2></legend>        
	<table class="CSSTable">
	<tr>
			<th><?php echo $this->Paginator->sort('Nombre'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($estadoregistros as $estadoregistro): ?>
	<tr>
		<td><?php echo h($estadoregistro['Estadoregistro']['descripcion']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $estadoregistro['Estadoregistro']['id'])); ?>
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $estadoregistro['Estadoregistro']['id'])); ?>
			<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $estadoregistro['Estadoregistro']['id']), null, __('Esta seguro que desea eliminar el estado %s?', $estadoregistro['Estadoregistro']['descripcion'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
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
</div>
<div class="actions">
	<legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
		<li><?php echo $this->Html->link(__('Nuevo Estado de registro'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Lista Regionales'), array('controller' => 'regionales', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Regional'), array('controller' => 'regionales', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Ciudades'), array('controller' => 'ciudades', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Ciudad'), array('controller' => 'ciudades', 'action' => 'add')); ?> </li>
	</ul>
</div>
