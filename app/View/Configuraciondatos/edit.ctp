<div class="configuraciondatos form">
<?php echo $this->Form->create('Configuraciondato'); ?>
	<fieldset>
		<legend><?php echo __('Edit Configuraciondato'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('nombre',array('class' => "alfanumeric"));
		echo $this->Form->input('valor');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Configuraciondato.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Configuraciondato.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Configuraciondatos'), array('action' => 'index')); ?></li>
	</ul>
</div>
