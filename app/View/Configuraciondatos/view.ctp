<div class="configuraciondatos view">
<h2><?php echo __('Configuraciondato'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($configuraciondato['Configuraciondato']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($configuraciondato['Configuraciondato']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Valor'); ?></dt>
		<dd>
			<?php echo h($configuraciondato['Configuraciondato']['valor']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Configuraciondato'), array('action' => 'edit', $configuraciondato['Configuraciondato']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Configuraciondato'), array('action' => 'delete', $configuraciondato['Configuraciondato']['id']), null, __('Are you sure you want to delete # %s?', $configuraciondato['Configuraciondato']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Configuraciondatos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Configuraciondato'), array('action' => 'add')); ?> </li>
	</ul>
</div>
