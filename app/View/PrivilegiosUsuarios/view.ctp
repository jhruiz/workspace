<?php $this->layout = 'inicio'; ?>
<div class="privilegiosUsuarios view">
<legend><h2><?php echo __('Privilegios Usuario'); ?></h2></legend>
	<dl>
		<dt><?php echo __('Privilegio'); ?></dt>
		<dd>
			<?php echo ($privilegiosUsuario['Privilegio']['descripcion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Usuario'); ?></dt>
		<dd>
			<?php echo $this->Html->link($privilegiosUsuario['Usuario']['nombre'], array('controller' => 'usuarios', 'action' => 'view', $privilegiosUsuario['Usuario']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Editar Privilegio - Usuario'), array('action' => 'edit', $privilegiosUsuario['PrivilegiosUsuario']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Privilegios - Usuarios'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Privilegio - Usuario'), array('action' => 'add')); ?> </li>
	</ul>
</div>
