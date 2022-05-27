<div class="paquetesUsuarios form">
<?php echo $this->Form->create('PaquetesUsuario'); ?>
	<fieldset>
		<legend><?php echo __('Edit Paquetes Usuario'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('paquete_id');
		echo $this->Form->input('usuario_id');
		echo $this->Form->input('asignado');
		echo $this->Form->input('fecha_asignacion');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('PaquetesUsuario.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('PaquetesUsuario.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Paquetes Usuarios'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Paquetes'), array('controller' => 'paquetes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Paquete'), array('controller' => 'paquetes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>
