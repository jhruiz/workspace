<?php $this->layout = 'inicio'; ?>
<div class="bandejas form">
<?php echo $this->Form->create('Bandeja'); ?>
	<fieldset>
		<legend><h2><?php echo __('Editar Bandeja'); ?></h2></legend>
	<?php
		echo $this->Form->input('id', array('type' => 'hidden'));
		echo $this->Form->input('descripcion', array('label' => 'Nombre'));
	?>
	</fieldset><br>
<?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
<div class="actions">
	<legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
		<li><?php echo $this->Html->link(__('Lista Bandejas'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Lista Estados'), array('controller' => 'estados', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Estado'), array('controller' => 'estados', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Semáforos'), array('controller' => 'semaforos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Semáforo'), array('controller' => 'semaforos', 'action' => 'add')); ?> </li>
	</ul>
</div>
