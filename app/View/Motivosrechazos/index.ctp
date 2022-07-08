<?php $this->layout = 'inicio'; ?>
<div class="motivosrechazos index">
	<legend><h2><?php echo __('Motivos de Rechazo'); ?></h2></legend>
	<table class="CSSTable">
	<tr>
			<th><?php echo ('Descripcion'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($motivosrechazos as $motivosrechazo): ?>
	<tr>
		<td><?php echo h($motivosrechazo['Motivosrechazo']['descripcion']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $motivosrechazo['Motivosrechazo']['id'])); ?>
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $motivosrechazo['Motivosrechazo']['id'])); ?>
			<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $motivosrechazo['Motivosrechazo']['id']), null, __('Está seguro que desea eliminar el motivo de rechazo %s?', $motivosrechazo['Motivosrechazo']['descripcion'])); ?>
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
		<li><?php echo $this->Html->link(__('Nuevo Motivo de Rechazo'), array('action' => 'add')); ?></li>
	</ul>
</div>
