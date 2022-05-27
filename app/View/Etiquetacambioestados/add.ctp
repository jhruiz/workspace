<?php $this->layout = 'inicio'; ?>
<div class="etiquetacambioestados form">
<?php echo $this->Form->create('Etiquetacambioestado'); ?>
	<fieldset>
		<legend><h2><?php echo __('Agregar Etiqueta Cambio Estado'); ?></h2></legend>
	<?php
		echo $this->Form->input('descripcion');
	?>
	</fieldset><br>
<?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
<div class="actions">
	<legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
		<li><?php echo $this->Html->link(__('Lista Etiqueta Cambio Estados'), array('action' => 'index')); ?></li>
	</ul>
</div>
