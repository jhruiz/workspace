<?php $this->layout = 'inicio'; ?>
<div class="motivosrechazos form">
<?php echo $this->Form->create('Motivosrechazo'); ?>
	<fieldset>
		<legend><h2><?php echo __('Agregar Motivo de Rechazo'); ?></h2></legend>
	<?php
		echo $this->Form->input('descripcion');
	?>
	</fieldset>
<?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Lista Motivos de Rechazos'), array('action' => 'index')); ?></li>
	</ul>
</div>
