<div class="documentosPaquetes index">
	<h2><?php echo __('Documentos Paquetes'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('documento_id'); ?></th>
			<th><?php echo $this->Paginator->sort('paquete_id'); ?></th>
			<th><?php echo $this->Paginator->sort('url_fisica'); ?></th>
			<th><?php echo $this->Paginator->sort('revisado'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($documentosPaquetes as $documentospaquete): ?>
	<tr>
		<td><?php echo h($documentospaquete['Documentospaquete']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($documentospaquete['Documento']['descripcion'], array('controller' => 'documentos', 'action' => 'view', $documentospaquete['Documento']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($documentospaquete['Paquete']['id'], array('controller' => 'paquetes', 'action' => 'view', $documentospaquete['Paquete']['id'])); ?>
		</td>
		<td><?php echo h($documentospaquete['Documentospaquete']['url_fisica']); ?>&nbsp;</td>
		<td><?php echo h($documentospaquete['Documentospaquete']['revisado']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $documentospaquete['Documentospaquete']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $documentospaquete['Documentospaquete']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $documentospaquete['Documentospaquete']['id']), null, __('Are you sure you want to delete # %s?', $documentospaquete['Documentospaquete']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Documentos Paquete'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Documentos'), array('controller' => 'documentos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Documento'), array('controller' => 'documentos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Paquetes'), array('controller' => 'paquetes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Paquete'), array('controller' => 'paquetes', 'action' => 'add')); ?> </li>
	</ul>
</div>
