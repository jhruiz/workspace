<div class="regionalesUsuarios form">
<?php echo $this->Form->create('RegionalesUsuario'); ?>
	<fieldset>
		<legend><?php echo __('Edit Regionales Usuario'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('regionale_id');
		echo $this->Form->input('usuario_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('RegionalesUsuario.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('RegionalesUsuario.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Regionales Usuarios'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Regionales'), array('controller' => 'regionales', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Regionale'), array('controller' => 'regionales', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>
