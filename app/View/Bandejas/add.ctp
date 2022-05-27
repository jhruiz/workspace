<?php $this->layout = 'inicio'; ?>
<div class="bandejas form">
<?php echo $this->Form->create('Bandeja'); ?>
	<fieldset>
		<legend><h2><?php echo __('Agregar Bandeja'); ?></h2></legend>
	<?php
		echo $this->Form->input('descripcion', array('label' => 'Nombre'));
	?>
	</fieldset><br>
<?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>