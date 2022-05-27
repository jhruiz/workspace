<div class="paquetes index">
	<h2><?php echo __('Paquetes'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_creacion'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_digitalizacion'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_recepcion_embargo'); ?></th>
			<th><?php echo $this->Paginator->sort('numero_oficio'); ?></th>
			<th><?php echo $this->Paginator->sort('estado_id'); ?></th>
			<th><?php echo $this->Paginator->sort('oficina_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($paquetes as $paquete): ?>
	<tr>
		<td><?php echo h($paquete['Paquete']['id']); ?>&nbsp;</td>
		<td><?php echo h($paquete['Paquete']['fecha_creacion']); ?>&nbsp;</td>
		<td><?php echo h($paquete['Paquete']['fecha_digitalizacion']); ?>&nbsp;</td>
		<td><?php echo h($paquete['Paquete']['fecha_recepcion_embargo']); ?>&nbsp;</td>
		<td><?php echo h($paquete['Paquete']['numero_oficio']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($paquete['Estado']['descripcion'], array('controller' => 'estados', 'action' => 'view', $paquete['Estado']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($paquete['Oficina']['descripcion'], array('controller' => 'oficinas', 'action' => 'view', $paquete['Oficina']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $paquete['Paquete']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $paquete['Paquete']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $paquete['Paquete']['id']), null, __('Are you sure you want to delete # %s?', $paquete['Paquete']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Paquete'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Estados'), array('controller' => 'estados', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estado'), array('controller' => 'estados', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Oficinas'), array('controller' => 'oficinas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Oficina'), array('controller' => 'oficinas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Observaciones'), array('controller' => 'observaciones', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Observacione'), array('controller' => 'observaciones', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Trazabilidades'), array('controller' => 'trazabilidades', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trazabilidade'), array('controller' => 'trazabilidades', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Eliminarmultis'), array('controller' => 'eliminarmultis', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Eliminarmulti'), array('controller' => 'eliminarmultis', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Documentos'), array('controller' => 'documentos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Documento'), array('controller' => 'documentos', 'action' => 'add')); ?> </li>
	</ul>
</div>
