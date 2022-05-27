<?php $this->layout = 'inicio'; ?>
<div class="auditorias view">
<legend><h2><?php echo __('Auditoría'); ?></h2></legend>
	<dl>
		
		<dt><?php echo __('Usuario'); ?></dt>
		<dd>
			<?php echo $this->Html->link($auditoria['Usuario']['nombre'], array('controller' => 'usuarios', 'action' => 'view', $auditoria['Usuario']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Descripción'); ?></dt>
		<dd>
			<?php echo h($auditoria['Auditoria']['descripcion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acción'); ?></dt>
		<dd>
			<?php echo h($auditoria['Auditoria']['accion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha'); ?></dt>
		<dd>
			<?php echo h($auditoria['Auditoria']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
		<li><?php echo $this->Html->link(__('Lista Auditorías'), array('action' => 'index')); ?> </li>		
		<li><?php echo $this->Html->link(__('Lista Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>
