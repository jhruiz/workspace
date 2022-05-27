<?php $this->layout = 'inicio'; ?>
<div class="estadosMotivosrechazos form">
<?php echo $this->Form->create('EstadosMotivosrechazo'); ?>
	<fieldset>
		<legend><h2><?php echo __('Edit Estados Motivosrechazo'); ?></h2></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('estado_id');
		echo $this->Form->input('motivosrechazo_id');
	?>
	</fieldset>
<?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Lista Estados - Motivos de Rechazo'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Lista Estados'), array('controller' => 'estados', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Estado'), array('controller' => 'estados', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Motivos de Rechazo'), array('controller' => 'motivosrechazos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Motivo de Rechazo'), array('controller' => 'motivosrechazos', 'action' => 'add')); ?> </li>
	</ul>
</div>
