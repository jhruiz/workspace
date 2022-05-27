<div class="configuraciondatos index">
	<h2><?php echo __('Configuraciondatos'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('nombre'); ?></th>
			<th><?php echo $this->Paginator->sort('valor'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($configuraciondatos as $configuraciondato): ?>
	<tr>
		<td><?php echo h($configuraciondato['Configuraciondato']['id']); ?>&nbsp;</td>
		<td><?php echo h($configuraciondato['Configuraciondato']['nombre']); ?>&nbsp;</td>
		<td><?php echo h($configuraciondato['Configuraciondato']['valor']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $configuraciondato['Configuraciondato']['id'])); ?>
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $configuraciondato['Configuraciondato']['id'])); ?>
			<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $configuraciondato['Configuraciondato']['id']), null, __('Are you sure you want to delete # %s?', $configuraciondato['Configuraciondato']['id'])); ?>
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
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Configuraciondato'), array('action' => 'add')); ?></li>
	</ul>
</div>
