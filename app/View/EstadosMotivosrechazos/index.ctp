<?php $this->layout = 'inicio'; ?>
<div class="estadosMotivosrechazos index">
	<legend><h2><?php echo __('Estados - Motivos de Rechazo'); ?></h2></legend>
        <table class="CSSTable">
	<tr>
			<th><?php echo $this->Paginator->sort('estado_id'); ?></th>
			<th><?php echo $this->Paginator->sort('motivosrechazo_id', 'Motivo de Rechazo'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($estadosMotivosrechazos as $estadosMotivosrechazo): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($estadosMotivosrechazo['Estado']['descripcion'], array('controller' => 'estados', 'action' => 'view', $estadosMotivosrechazo['Estado']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($estadosMotivosrechazo['Motivosrechazo']['descripcion'], array('controller' => 'motivosrechazos', 'action' => 'view', $estadosMotivosrechazo['Motivosrechazo']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $estadosMotivosrechazo['EstadosMotivosrechazo']['id'])); ?>
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $estadosMotivosrechazo['EstadosMotivosrechazo']['id'])); ?>
			<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $estadosMotivosrechazo['EstadosMotivosrechazo']['id']), null, __('Está seguro que desea eliminar la relación?')); ?>
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
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Nuevo Estado - Motivo de Rechazo'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Lista Estados'), array('controller' => 'estados', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Estado'), array('controller' => 'estados', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Motivos de rechazo'), array('controller' => 'motivosrechazos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Motivo de Rechazo'), array('controller' => 'motivosrechazos', 'action' => 'add')); ?> </li>
	</ul>
</div>
