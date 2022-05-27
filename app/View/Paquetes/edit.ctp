<div class="paquetes form">
<?php echo $this->Form->create('Paquete'); ?>
	<fieldset>
		<legend><?php echo __('Edit Paquete'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('fecha_creacion');
		echo $this->Form->input('fecha_digitalizacion');
		echo $this->Form->input('fecha_recepcion_embargo');
		echo $this->Form->input('numero_oficio');
		echo $this->Form->input('estado_id');
		echo $this->Form->input('oficina_id');
		echo $this->Form->input('Usuario');
		echo $this->Form->input('Documento');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Paquete.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Paquete.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Paquetes'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Estados'), array('controller' => 'estados', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estado'), array('controller' => 'estados', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Oficinas'), array('controller' => 'oficinas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Oficina'), array('controller' => 'oficinas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Observaciones'), array('controller' => 'observaciones', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Observacione'), array('controller' => 'observaciones', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Trazabilidades'), array('controller' => 'trazabilidades', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trazabilidade'), array('controller' => 'trazabilidades', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Eliminarmultis'), array('controller' => 'eliminarmultis', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Eliminarmulti'), array('controller' => 'eliminarmultis', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Documentos'), array('controller' => 'documentos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Documento'), array('controller' => 'documentos', 'action' => 'add')); ?> </li>
	</ul>
</div>
