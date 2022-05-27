<?php $this->layout = 'inicio'; ?>
<div class="paquetesUsuarios view">
<h2><?php echo __('Paquetes Usuario'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($paquetesUsuario['PaquetesUsuario']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Paquete'); ?></dt>
		<dd>
			<?php echo $this->Html->link($paquetesUsuario['Paquete']['id'], array('controller' => 'paquetes', 'action' => 'view', $paquetesUsuario['Paquete']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Usuario'); ?></dt>
		<dd>
			<?php echo $this->Html->link($paquetesUsuario['Usuario']['nombre'], array('controller' => 'usuarios', 'action' => 'view', $paquetesUsuario['Usuario']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Asignado'); ?></dt>
		<dd>
			<?php echo h($paquetesUsuario['PaquetesUsuario']['asignado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Asignacion'); ?></dt>
		<dd>
			<?php echo h($paquetesUsuario['PaquetesUsuario']['fecha_asignacion']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Paquetes Usuario'), array('action' => 'edit', $paquetesUsuario['PaquetesUsuario']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Paquetes Usuario'), array('action' => 'delete', $paquetesUsuario['PaquetesUsuario']['id']), null, __('Are you sure you want to delete # %s?', $paquetesUsuario['PaquetesUsuario']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Paquetes Usuarios'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Paquetes Usuario'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Paquetes'), array('controller' => 'paquetes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Paquete'), array('controller' => 'paquetes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>
