<?php $this->layout = 'inicio'; ?>
<div class="diasfestivos view">
<legend><h2><?php echo __('Días Festivo'); ?></h2></legend>
	<dl>
		<dt><?php echo __('Día Festivo'); ?></dt>
		<dd>
			<?php echo h($diasfestivo['Diasfestivo']['fecha']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Descripción'); ?></dt>
		<dd>
			<?php echo h($diasfestivo['Diasfestivo']['descripcion']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Editar Día Festivo'), array('action' => 'edit', $diasfestivo['Diasfestivo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Días Festivos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Día Festivo'), array('action' => 'add')); ?> </li>
	</ul>
</div>
