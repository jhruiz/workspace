<?php
    $this->layout='inicio';
?>
<div class="oficinas view">
<legend><h2><?php echo __('Oficina'); ?></h2></legend>
	<dl>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($oficina['Oficina']['descripcion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ciudad'); ?></dt>
		<dd>
			<?php echo $this->Html->link($oficina['Ciudade']['descripcion'], array('controller' => 'ciudades', 'action' => 'view', $oficina['Ciudade']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
		<li><?php echo $this->Html->link(__('Editar Oficina'), array('action' => 'edit', $oficina['Oficina']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Oficinas'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Oficina'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Ciudades'), array('controller' => 'ciudades', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Ciudad'), array('controller' => 'ciudades', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>
