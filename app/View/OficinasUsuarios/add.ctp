<div class="oficinasUsuarios form">
<?php echo $this->Form->create('OficinasUsuario'); ?>
	<fieldset>
		<legend><?php echo __('Add Oficinas Usuario'); ?></legend>
	<?php
		echo $this->Form->input('oficina_id');
		echo $this->Form->input('usuario_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Oficinas Usuarios'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Oficinas'), array('controller' => 'oficinas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Oficina'), array('controller' => 'oficinas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>
