<div class="documentosPaquetes form">
<?php echo $this->Form->create('Documentospaquete'); ?>
	<fieldset>
		<legend><?php echo __('Add Documentos Paquete'); ?></legend>
	<?php
		echo $this->Form->input('documento_id');
		echo $this->Form->input('paquete_id');
		echo $this->Form->input('url_fisica');
		echo $this->Form->input('revisado');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Documentos Paquetes'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Documentos'), array('controller' => 'documentos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Documento'), array('controller' => 'documentos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Paquetes'), array('controller' => 'paquetes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Paquete'), array('controller' => 'paquetes', 'action' => 'add')); ?> </li>
	</ul>
</div>
